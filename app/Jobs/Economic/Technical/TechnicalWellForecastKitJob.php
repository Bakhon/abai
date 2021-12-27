<?php

namespace App\Jobs\Economic\Technical;

use App\Models\Refs\EcoRefsAnalysisParam;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellForecastKit;
use App\Models\Refs\TechnicalWellLossStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use SplFixedArray;

class TechnicalWellForecastKitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 6000;

    public $kitId;

    public $permanentStopCoefficient;

    const DEFAULT_WHERE_IN_PARAM = "''";

    const OIL_FACTOR = 10;
    const OIL_DEVIATION = 1;

    public function __construct(int $kitId, float $permanentStopCoefficient)
    {
        $this->kitId = $kitId;

        $this->permanentStopCoefficient = $permanentStopCoefficient;
    }

    public function handle()
    {
        ini_set('max_execution_time', $this->timeout);

        ini_set('memory_limit', '-1');

        /** @var TechnicalWellForecastKit $kit */
        $kit = TechnicalWellForecastKit::find($this->kitId);

        if (!$kit) return;

        list($enabledUwis, $stoppedUwis) = self::getProposedWells(
            $kit->economic_log_id,
            $kit->technical_log_id,
            $this->permanentStopCoefficient
        );

        DB::transaction(function () use ($kit, $enabledUwis, $stoppedUwis) {
            $kit->results()->create([
                'enabled_uwis' => $enabledUwis,
                'stopped_uwis' => $stoppedUwis,
                'permanent_stop_coefficient' => $this->permanentStopCoefficient
            ]);

            $kit->increment("calculated_variants");
        });
    }

    public function getProposedWells(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient
    ): array
    {
        $profitableStoppedWells = self::getProfitableStoppedWellsByDate(
            $economicLogId,
            $technicalLogId,
            $permanentStopCoefficient
        );

        $profitableUwis = [];

        $profitableOilLoss = 0;

        foreach ($profitableStoppedWells as $well) {
            $well = (array)$well;

            $profitableUwis[] = $well['uwi'];

            $profitableOilLoss += (float)$well['oil_loss'];
        }

        $profitlessWells = self::getProfitlessWellsWithOil(
            $economicLogId,
            $technicalLogId,
            $permanentStopCoefficient,
            $profitableOilLoss,
        );

        $profitlessStoppedWells = self::getWellsForOilLimitWithMaxOperatingProfit(
            $profitlessWells,
            $profitableOilLoss
        );

        return $proposedWells = [
            $profitableUwis,
            $profitlessStoppedWells['uwis']
        ];
    }

    public static function getProfitableStoppedWellsByDate(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $lossStatuses = self::sqlQueryLossStatuses(true);

        $wells = DB::table("$tableWellForecast as well_forecast")
            ->select(DB::raw("
                well_forecast.uwi, 
                well_forecast.date_month, 
                SUM(well_forecast.oil_loss) as oil_loss
            "))
            ->whereRaw(DB::raw("
                well_forecast.log_id = $technicalLogId AND
                well_forecast.loss_status_id IN ($lossStatuses)
            "))
            ->groupBy(["uwi", "date_month"])
            ->toSql();

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.date_month,
                wells.oil_loss
            "))
            ->whereRaw(DB::raw("well_profitability.profitability = 'profitable'"));

        return self::sqlJoinWellProfitability(
            $query,
            $economicLogId,
            $technicalLogId,
            $permanentStopCoefficient
        )
            ->get()
            ->toArray();
    }

    public static function getProfitlessWellsWithOil(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
        float $oilLoss
    ): array
    {
        $oilLoss = abs($oilLoss);

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $netBack = self::sqlQueryNetBack();

        $overallExpenditures = self::sqlQueryOverallExpenditures(
            $permanentStopCoefficient
        );

        $lossStatuses = self::sqlQueryLossStatuses();

        $excludedUwis = DB::table($tableWellForecast)
            ->addSelect(DB::raw("DISTINCT uwi"))
            ->whereRaw(DB::raw("
                log_id = $technicalLogId AND
                loss_status_id IN ($lossStatuses)
            "))
            ->toSql();

        $query = DB::table("$tableWellForecast as well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi, 
                SUM(well_forecast.oil) as oil_sum,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->whereRaw(DB::raw("
                well_forecast.log_id = $technicalLogId AND
                well_forecast.uwi NOT IN ($excludedUwis)
            "))
            ->havingRaw(DB::raw("
                operating_profit <= 0 and oil_sum > 0 and oil_sum <= $oilLoss
            "))
            ->groupBy("uwi")
            ->orderBy("operating_profit");

        return self::sqlJoinAnalysisParam($query, $economicLogId)
            ->get()
            ->toArray();
    }

    public static function getWellsForOilLimitWithMaxOperatingProfit(
        array $wells,
        float $oilLimit
    ): array
    {
        $oilLimit = (int)floor(abs($oilLimit) * self::OIL_FACTOR * self::OIL_DEVIATION);

        $wellsCount = count($wells);

        foreach ($wells as &$well) {
            $well = (array)$well;

            $well['weight'] = -$well['operating_profit'];

            $well['oil'] = (int)ceil($well['oil_sum'] * self::OIL_FACTOR);
        }

        $stoppedWells = [
            'uwis' => [],
            'oil' => 0,
            'operating_profit' => 0
        ];

        $table = new SplFixedArray($wellsCount + 1);

        for ($j = 0; $j < $wellsCount + 1; $j++) {
            $table[$j] = new SplFixedArray($oilLimit + 1);
        }

        for ($j = 1; $j <= $wellsCount; $j += 1) {
            $well = $wells[$j - 1];

            for ($w = 1; $w <= $oilLimit; $w += 1) {
                $table[$j][$w] = $well['oil'] > $w
                    ? $table[$j - 1][$w]
                    : max(
                        $table[$j - 1][$w],
                        $table[$j - 1][$w - $well['oil']] + $well['weight']
                    );
            }
        }

        $j = $wellsCount;

        while ($j > 0) {
            if ($table[$j][$oilLimit] !== $table[$j - 1][$oilLimit]) {
                $well = $wells[$j - 1];

                $stoppedWells['uwis'][] = $well['uwi'];

                $stoppedWells['oil'] += $well['oil_sum'];

                $stoppedWells['operating_profit'] += $well['operating_profit'];

                $oilLimit -= $well['oil'];
            }

            $j -= 1;
        }

        return $stoppedWells;
    }

    public static function sqlQueryNetBack(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param',
        string $oil = null
    ): string
    {
        if ($oil === null) {
            $oil = self::sqlQueryOil($enabledUwis, $stoppedUwis, $wellForecastAlias);
        }

        return "$oil * $analysisParamAlias.netback_fact / 1000";
    }

    public static function sqlQueryOverallExpenditures(
        float $permanentStopCoefficient,
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param',
        string $liquid = null,
        string $prsPortion = null
    ): string
    {
        if ($liquid === null) {
            $liquid = self::sqlQueryLiquid($enabledUwis, $stoppedUwis, $wellForecastAlias);
        }

        if ($prsPortion === null) {
            $prsPortion = self::sqlQueryPrsPortion($stoppedUwis, $wellForecastAlias);
        }

        return "
        CASE WHEN $liquid > 0
             THEN $analysisParamAlias.permanent_cost
             ELSE $analysisParamAlias.permanent_cost * $permanentStopCoefficient	
        END + 
        $liquid * $analysisParamAlias.variable_cost * $analysisParamAlias.oil_density / 1000 +
        $prsPortion * $analysisParamAlias.avg_prs_cost
        ";
    }

    public static function sqlQueryOil(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.oil";
        }

        $enabledUwis = self::buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = self::buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN $wellForecastAlias.oil_forecast
                    ELSE $wellForecastAlias.oil
               END";
    }

    public static function sqlQueryLiquid(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.liquid";
        }

        $enabledUwis = self::buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = self::buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                     THEN 0
                     WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                     THEN $wellForecastAlias.liquid_forecast
                     ELSE $wellForecastAlias.liquid
               END";
    }

    public static function sqlQueryPrsPortion(
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$stoppedUwis) {
            return "$wellForecastAlias.prs_portion";
        }

        $stoppedUwis = self::buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                     THEN 0
                     ELSE $wellForecastAlias.prs_portion
               END";
    }

    public static function sqlQueryProfitability(string $operatingProfit = 'operating_profit'): string
    {
        return "CASE WHEN $operatingProfit > 0 THEN 'profitable' ELSE 'profitless' END";
    }

    public static function sqlQueryLossStatuses(bool $hasDeoptimization = false): string
    {
        $statuses = TechnicalWellLossStatus::factualIds();

        if ($hasDeoptimization) {
            $statuses[] = TechnicalWellLossStatus::DEOPTIMIZATION;
        }

        return implode(",", $statuses);
    }

    public static function sqlJoinAnalysisParam(
        Builder $query,
        int $economicLogId,
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param'
    ): Builder
    {
        $tableAnalysisParams = (new EcoRefsAnalysisParam())->getTable();

        return $query->leftjoin(
            "$tableAnalysisParams AS $analysisParamAlias",
            function ($join) use ($wellForecastAlias, $analysisParamAlias, $economicLogId) {
                /** @var JoinClause $join */
                $join
                    ->on(
                        DB::raw("$wellForecastAlias.date_month"),
                        '=',
                        DB::raw("$analysisParamAlias.date")
                    )
                    ->whereRaw(DB::raw("$analysisParamAlias.log_id = $economicLogId"));
            });
    }

    public static function sqlJoinWellProfitability(
        Builder $query,
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
        string $wellAlias = "wells",
        string $wellProfitabilityAlias = "well_profitability",
        array $enabledUwis = null,
        array $stoppedUwis = null
    ): Builder
    {
        $wells = self::builderWellProfitability(
            $economicLogId,
            $technicalLogId,
            $permanentStopCoefficient,
            $enabledUwis,
            $stoppedUwis
        )->toSql();

        return $query->leftJoin(
            DB::raw("($wells) as $wellProfitabilityAlias"),
            function ($join) use ($wellAlias, $wellProfitabilityAlias) {
                /** @var JoinClause $join */
                $join
                    ->on("$wellProfitabilityAlias.date", "=", "$wellAlias.date_month")
                    ->on("$wellProfitabilityAlias.uwi", "=", "$wellAlias.uwi");
            });
    }

    public static function buildSqlQueryWhereIn(array $stringParams = null): string
    {
        return $stringParams
            ? "'" . implode("','", $stringParams) . "'"
            : self::DEFAULT_WHERE_IN_PARAM;
    }

    public static function builderWellProfitability(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
        array $enabledUwis = null,
        array $stoppedUwis = null
    ): Builder
    {
        $netBack = self::sqlQueryNetBack();

        $netBackPropose = self::sqlQueryNetBack($enabledUwis, $stoppedUwis);

        $netBackStop = self::sqlQueryNetBack(
            null,
            null,
            "well_forecast",
            "analysis_param",
            "0"
        );

        $overallExpenditures = self::sqlQueryOverallExpenditures(
            $permanentStopCoefficient
        );

        $overallExpendituresPropose = self::sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            $enabledUwis,
            $stoppedUwis
        );

        $overallExpendituresWithoutPrs = self::sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            null,
            null,
            "well_forecast",
            "analysis_param",
            null,
            "0"
        );

        $overallExpendituresStop = self::sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            null,
            null,
            "well_forecast",
            "analysis_param",
            "0",
            "0"
        );

        $profitability = self::sqlQueryProfitability();

        $profitabilityPropose = self::sqlQueryProfitability('operating_profit_propose');

        $profitabilityWithoutPrs = self::sqlQueryProfitability('operating_profit_without_prs');

        $wells = DB::table((new TechnicalWellForecast())->getTable())
            ->whereRaw(DB::raw("log_id = $technicalLogId"))
            ->orderByRaw(DB::raw("date_month"))
            ->toSql();

        $query = DB::table(DB::raw("($wells) AS well_forecast"))
            ->addSelect(DB::raw("
                well_forecast.uwi,
                analysis_param.date,
                analysis_param.netback_fact,
                analysis_param.permanent_cost,
                analysis_param.variable_cost,
                analysis_param.avg_prs_cost,
                analysis_param.oil_density,
                SUM($netBack - ($overallExpenditures)) as operating_profit,
                SUM($netBack - ($overallExpendituresWithoutPrs)) as operating_profit_without_prs,
                SUM($netBackPropose - ($overallExpendituresPropose)) as operating_profit_propose,
                SUM($netBackStop - ($overallExpendituresStop)) as operating_profit_stop
            "))
            ->groupByRaw(DB::raw("
                well_forecast.uwi,
                analysis_param.date,
                analysis_param.netback_fact,
                analysis_param.permanent_cost,
                analysis_param.variable_cost,
                analysis_param.avg_prs_cost,
                analysis_param.oil_density
            "));

        $wells = self::sqlJoinAnalysisParam($query, $economicLogId)->toSql();

        return DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.date,
                wells.netback_fact,
                wells.permanent_cost,
                wells.variable_cost,
                wells.avg_prs_cost,
                wells.oil_density,
                $profitability as profitability,
                $profitabilityPropose as profitability_propose,
                $profitabilityWithoutPrs as profitability_without_prs,
                SUM(operating_profit) as operating_profit,
                SUM(operating_profit_propose) as operating_profit_propose,
                SUM(operating_profit_stop) as operating_profit_stop,
                SUM(operating_profit_without_prs) as operating_profit_without_prs
            "))
            ->groupByRaw(DB::raw("
                wells.uwi,
                wells.date,
                wells.netback_fact,
                wells.permanent_cost,
                wells.variable_cost,
                wells.avg_prs_cost,
                wells.oil_density,
                profitability,
                profitability_propose,
                profitability_without_prs
            "))
            ->orderByRaw(DB::raw("wells.date, wells.uwi"));
    }
}

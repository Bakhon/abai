<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Models\Refs\EcoRefsAnalysisParam;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellLossStatus;
use App\Models\Refs\TechnicalWellStatus;
use App\Services\BigData\StructureService;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Level23\Druid\DruidClient;
use SplFixedArray;

class EconomicAnalysisController extends Controller
{
    protected $druidClient;
    protected $structureService;

    const TABLE_WELL_FORECAST = 'well_forecast';

    const OIL_FACTOR = 1;

    const OIL_LOSS_STATUSES = [7, 9, 21];

    const NULLABLE_WHERE_IN_PARAM = "''";

    public function __construct(DruidClient $druidClient, StructureService $structureService)
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'getData');

        $this->druidClient = $druidClient;

        $this->structureService = $structureService;
    }

    public function index(): View
    {
        return view('economic.analysis');
    }

    public function inputParams(): View
    {
        return view('economic.analysis.input_params');
    }

    public function getData(): array
    {
//        if (Cache::has('analysisWells')) {
//            list($profitableWells, $stoppedWells) = json_decode(Cache::get('analysisWells'), true);
//        } else {
        $wells = $this->getProposedWells();

//            Cache::put('analysisWells', json_encode($wells, true), now()->addDay());

        list($profitableWells, $stoppedWells) = $wells;
//        }


        $profitableWells = $this->buildSqlQueryWhereIn($profitableWells);

        $stoppedWells = $this->buildSqlQueryWhereIn($stoppedWells);

        $tableWellStatus = (new TechnicalWellStatus())->getTable();

        $tableWellLossStatus = (new TechnicalWellLossStatus())->getTable();

        return [
//            'wells' => $this->getSumWellsParams(),
//            'proposedWells' => $this->getSumWellsParams(
//                $profitableWells,
//                $stoppedWells
//            ),
//            'wellsByStatus' => $this->getSumWellsParamsByStatus(
//                $tableWellStatus,
//                'status_id'
//            ),
//            'wellsByLossStatus' => $this->getSumWellsParamsByStatus(
//                $tableWellLossStatus,
//                'loss_status_id'
//            ),
//            'proposedWellsByStatus' => $this->getSumWellsParamsByStatus(
//                $tableWellStatus,
//                'status_id',
//                $profitableWells,
//                $stoppedWells
//            ),
//            'proposedWellsByLossStatus' => $this->getSumWellsParamsByStatus(
//                $tableWellLossStatus,
//                'loss_status_id',
//                $profitableWells,
//                $stoppedWells
//            ),
        ];
    }

    private function getSumWellsParams(
        string $profitableUwis = "''",
        string $stoppedUwis = "''"
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $oil = $this->sqlQueryOil($profitableUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($profitableUwis, $stoppedUwis);

        $liquid = $this->sqlQueryLiquid($profitableUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($profitableUwis, $stoppedUwis);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis);

        $netBack = $this->sqlQueryNetBack($profitableUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures($profitableUwis, $stoppedUwis);

        $profitability = $this->sqlQueryProfitability('well_query');

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                analysis_param.date as date,    
                analysis_param.netback_fact as netback_fact,    
                analysis_param.variable_cost as variable_cost,    
                analysis_param.permanent_cost as permanent_cost,    
                analysis_param.avg_prs_cost as avg_prs_cost,    
                analysis_param.oil_density as oil_density,    
                well_forecast.uwi as uwi,
                SUM(well_forecast.active_hours) as active_hours,
                SUM(well_forecast.paused_hours) as paused_hours,
                SUM(well_forecast.active_hours + well_forecast.paused_hours) as total_hours,    
                SUM($oil) as oil,
                SUM($oilLoss) as oil_loss,
                SUM($liquid) as liquid,
                SUM($liquidLoss) as liquid_loss,
                SUM($prsPortion) as prs_portion,
                SUM($netBack) as netback,
                SUM($overallExpenditures) as overall_expenditures,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->groupBy([
                "uwi",
                "date",
                "netback_fact",
                "variable_cost",
                "permanent_cost",
                "avg_prs_cost",
                "oil_density",
            ]);

        $wells = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        $columns = [
            "uwi",
            "date",
            "netback_fact",
            "variable_cost",
            "permanent_cost",
            "avg_prs_cost",
            "oil_density",
        ];

        return DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.date,
                wells.netback_fact,
                wells.variable_cost,
                wells.permanent_cost,
                wells.avg_prs_cost,
                wells.oil_density,
                well_profitability.profitability as profitability,
                SUM(wells.oil) as oil,
                SUM(wells.oil_loss) as oil_loss,
                SUM(wells.liquid) as liquid,
                SUM(wells.liquid_loss) as liquid_loss,
                SUM(wells.active_hours) as active_hours,
                SUM(wells.paused_hours) as paused_hours,
                SUM(wells.total_hours) as total_hours,
                SUM(wells.prs_portion) as prs_portion,
                SUM(wells.netback) as netback,
                SUM(wells.overall_expenditures) as overall_expenditures,
                SUM(wells.operating_profit) as operating_profit,
                $profitability as profitability
            "))
            ->groupBy(array_merge($columns, ['profitability']))
            ->get()
            ->toArray();
    }

    private function getSumWellsParamsByStatus(
        string $tableWellStatus,
        string $joinKey,
        string $profitableUwis = "''",
        string $stoppedUwis = "''"
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $oil = $this->sqlQueryOil($profitableUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($profitableUwis, $stoppedUwis);

        $liquid = $this->sqlQueryLiquid($profitableUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($profitableUwis, $stoppedUwis);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis);

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                analysis_param.date as date,
                well_forecast.uwi as uwi,
                well_status.id as status_id,    
                well_status.name as status_name,
                SUM(well_forecast.active_hours) as active_hours,
                SUM(well_forecast.paused_hours) as paused_hours,
                SUM(well_forecast.active_hours + well_forecast.paused_hours) as total_hours,    
                SUM(well_forecast.oil_forecast) as oil_forecast,
                SUM($oil) as oil,
                SUM($oilLoss) as oil_loss,
                SUM($liquid) as liquid,
                SUM($liquidLoss) as liquid_loss,
                SUM($prsPortion) as prs_portion
            "))
            ->leftjoin("$tableWellStatus AS well_status", function ($join) use ($joinKey) {
                /** @var JoinClause $join */
                $join->on("well_forecast.$joinKey", '=', 'well_status.id');
            })
            ->whereNotNull($joinKey)
            ->groupBy([
                "date",
                "uwi",
                "status_name",
                $joinKey
            ]);

        $wells = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.status_name as status_name,
                wells.status_id as status_id,
                wells.date as date,
                well_profitability.profitability as profitability,
                COUNT(wells.uwi) AS uwi_count,
                SUM(wells.oil) AS oil,
                SUM(wells.oil_loss) AS oil_loss,
                SUM(wells.oil_forecast) AS oil_forecast,
                SUM(wells.liquid) AS liquid,
                SUM(wells.liquid_loss) AS liquid_loss,
                SUM(wells.active_hours) AS active_hours,
                SUM(wells.paused_hours) AS paused_hours,
                SUM(wells.total_hours) AS total_hours,
                SUM(wells.prs_portion) AS prs_portion
            "))
            ->groupBy([
                "date",
                "status_name",
                "status_id",
                "profitability",
            ]);

        return $this
            ->sqlJoinWellProfitability(
                $query,
                'wells',
                'well_profitability',
                $profitableUwis,
                $stoppedUwis
            )
            ->get()
            ->toArray();
    }

    public function getProposedWells(): array
    {
        $profitableStoppedWells = $this->getProfitableStoppedWellsByDate();

        $profitableWellsByDate = [];

        foreach ($profitableStoppedWells as $well) {
            $well = (array)$well;

            $date = $well['date'];

            if (!isset($profitableWellsByDate[$date])) {
                $profitableWellsByDate[$date] = [
                    'oil_loss' => 0,
                    'uwis' => []
                ];
            }

            $profitableWellsByDate[$date]['uwis'][] = $well["uwi"];

            $profitableWellsByDate[$date]['oil_loss'] += (float)$well['oil_loss'];
        }

        foreach ($profitableWellsByDate as $date => $profitableStoppedWells) {
            $profitlessWells = $this->getProfitlessWellsWithOil(
                $profitableStoppedWells['oil_loss'],
                $date
            );

            dd($profitlessWells);

            dd('aa', $profitlessWells);

            $profitlessStoppedWells = $this->getWellsForOilLimitWithMaxOperatingProfit(
                $profitlessWells,
                $profitableStoppedWells['oil_loss']
            );

            dd($profitlessStoppedWells);

            return [
                $profitableStoppedWells['uwis'],
                $profitlessStoppedWells['uwis']
            ];
        }
    }

    private function getProfitableStoppedWellsByDate(): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $lossStatuses = implode(",", self::OIL_LOSS_STATUSES);

        $query = DB::table("$tableWellForecast as well_forecast")
            ->select(DB::raw("
                well_forecast.uwi as uwi, 
                analysis_param.date as date,
                SUM(well_forecast.oil) as oil,
                SUM(well_forecast.oil_loss) as oil_loss,
                SUM(well_forecast.oil_forecast) as oil_forecast
                "
            ))
            ->whereRaw("well_forecast.status_id IN ($lossStatuses)")
            ->groupBy(["uwi", "date"]);

        $wells = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.date,
                wells.oil,
                wells.oil_loss,
                wells.oil_forecast,
                well_profitability.profitability
            "))
            ->whereRaw(DB::raw("well_profitability.profitability = 'profitable'"));

        return $this
            ->sqlJoinWellProfitability($query, 'wells', 'well_profitability')
            ->get()
            ->toArray();
    }

    private function getProfitlessWellsWithOil(float $oilLoss, string $date): array
    {
        $oilLoss = abs($oilLoss);

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $netBack = $this->sqlQueryNetBack();

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

        $query = DB::table("$tableWellForecast as well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi, 
                SUM(well_forecast.oil) as oil_sum,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->whereRaw(DB::raw("
                well_forecast.loss_status_id is NULL and analysis_param.date = '$date'
            "))
            ->havingRaw(DB::raw("
                operating_profit <= 0 and oil_sum > 0 and oil_sum <= $oilLoss
            "))
            ->groupBy("uwi")
            ->orderBy("operating_profit");

        return $this
            ->sqlJoinAnalysisParam($query)
            ->get()
            ->toArray();
    }

    private function getWellsForOilLimitWithMaxOperatingProfit(array $wells, float $oilLimit): array
    {
        $oilLimit = (int)floor(abs($oilLimit) * self::OIL_FACTOR);

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

    private function sqlQueryNetBack(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param'
    ): string
    {
        $oil = $this->sqlQueryOil($profitableUwis, $stoppedUwis, $wellForecastAlias);

        return "$oil * $analysisParamAlias.netback_fact / 1000";
    }

    private function sqlQueryOverallExpenditures(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param'
    ): string
    {
        $liquid = $this->sqlQueryLiquid($profitableUwis, $stoppedUwis, $wellForecastAlias);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis, $wellForecastAlias);

        return "
        CASE WHEN $liquid > 0
             THEN $analysisParamAlias.permanent_cost
             ELSE $analysisParamAlias.permanent_stop_cost	
        END + 
        $liquid * $analysisParamAlias.variable_cost * $analysisParamAlias.oil_density / 1000 +
        $prsPortion * $analysisParamAlias.avg_prs_cost
        ";
    }

    private function sqlQueryProfitability(string $tableAlias): string
    {
        return "CASE WHEN $tableAlias.operating_profit > 0 THEN 'profitable' ELSE 'profitless' END";
    }

    private function sqlQueryOil(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        return $profitableUwis === self::NULLABLE_WHERE_IN_PARAM && $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "$wellForecastAlias.oil"
            : "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($profitableUwis)
                    THEN $wellForecastAlias.oil_forecast * 10000000000000000000
                    ELSE $wellForecastAlias.oil
               END";
    }

    private function sqlQueryOilLoss(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        return $profitableUwis === self::NULLABLE_WHERE_IN_PARAM && $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "$wellForecastAlias.oil_loss"
            : "CASE WHEN $wellForecastAlias.uwi IN ($profitableUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN $wellForecastAlias.oil
                    ELSE $wellForecastAlias.oil_loss
               END";
    }

    private function sqlQueryLiquid(
        string $profitableUwis,
        string $stoppedUwis,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        return $profitableUwis === self::NULLABLE_WHERE_IN_PARAM && $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "$wellForecastAlias.liquid"
            : "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($profitableUwis)
                    THEN $wellForecastAlias.liquid_forecast
                    ELSE $wellForecastAlias.liquid
               END";
    }

    private function sqlQueryLiquidLoss(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        return $profitableUwis === self::NULLABLE_WHERE_IN_PARAM && $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "$wellForecastAlias.liquid_loss"
            : "CASE WHEN $wellForecastAlias.uwi IN ($profitableUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN $wellForecastAlias.liquid
                    ELSE $wellForecastAlias.liquid_loss
               END";
    }

    private function sqlQueryPrsPortion(
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        return $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "$wellForecastAlias.prs_portion"
            : "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    ELSE $wellForecastAlias.prs_portion
               END";
    }


    private function sqlJoinAnalysisParam(
        Builder $query,
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param'
    ): Builder
    {
        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        return $query->leftjoin("$tableAnalysisParam AS $analysisParamAlias", function ($join) use ($wellForecastAlias, $analysisParamAlias) {
            /** @var JoinClause $join */
            $join->on(
                DB::raw("MONTH($wellForecastAlias.date)"),
                '=',
                DB::raw("MONTH($analysisParamAlias.date)")
            )->on(
                DB::raw("YEAR($wellForecastAlias.date)"),
                '=',
                DB::raw("YEAR($analysisParamAlias.date)")
            );
        });
    }

    private function sqlJoinWellProfitability(
        Builder $query,
        string $wellAlias,
        string $wellProfitabilityAlias,
        string $profitableUwis = "''",
        string $stoppedUwis = "''"
    ): Builder
    {
        $wells = $this
            ->builderWellProfitability($profitableUwis, $stoppedUwis)
            ->toSql();

        return $query->leftJoin(DB::raw("($wells) as $wellProfitabilityAlias"), function ($join) use ($wellAlias, $wellProfitabilityAlias) {
            /** @var JoinClause $join */
            $join
                ->on("$wellProfitabilityAlias.uwi", "=", "$wellAlias.uwi")
                ->on("$wellProfitabilityAlias.date", "=", "$wellAlias.date");
        });
    }

    private function buildSqlQueryWhereIn(array $stringParams): string
    {
        return $stringParams
            ? "'" . implode("','", $stringParams) . "'"
            : self::NULLABLE_WHERE_IN_PARAM;
    }

    private function builderWellProfitability(
        string $profitableUwis = "''",
        string $stoppedUwis = "''"
    ): Builder
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $netBack = $this->sqlQueryNetBack($profitableUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures($profitableUwis, $stoppedUwis);

        $profitability = $this->sqlQueryProfitability('well_query');

        $columns = ["uwi", "date"];

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi as uwi,
                analysis_param.date as date,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->groupBy($columns);

        $query = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        return DB::table(DB::raw("($query) as well_query"))
            ->addSelect($columns)
            ->addSelect(DB::raw("$profitability as profitability"))
            ->groupBy(array_merge($columns, ['profitability']));
    }

}

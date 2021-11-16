<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Analysis\EconomicAnalysisWellRequest;
use App\Models\Refs\EcoRefsAnalysisParam;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellLossStatus;
use App\Models\Refs\TechnicalWellStatus;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Level23\Druid\Types\Granularity;
use SplFixedArray;

class EconomicAnalysisController extends Controller
{
    const CACHE_KEY = 'economic_analysis';
    const CACHE_BY_DATE_KEY = 'economic_analysis_by_date';

    const NULLABLE_WHERE_IN_PARAM = "''";

    const TABLE_WELL_FORECAST = 'well_forecast';

    const OIL_FACTOR = 1;
    const OIL_DEVIATION = 1;

    const CHANGED_STATUS_NOT_CHANGE = 0;
    const CHANGED_STATUS_STOP = -1;
    const CHANGED_STATUS_LAUNCH = 1;
    const CHANGED_STATUS_DEOPTIMIZATION = 2;

    public function __construct()
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'getData', 'getWells');
    }

    public function index(): View
    {
        return view('economic.analysis');
    }

    public function inputParams(): View
    {
        return view('economic.analysis.input_params');
    }

    public function indexWells(): View
    {
        return view('economic.analysis.wells');
    }

    public function getData(): array
    {
        $proposedWells = $this->getProposedWells();

        if (!Cache::has(self::CACHE_KEY)) {
            Cache::put(
                self::CACHE_KEY,
                json_encode($proposedWells, true),
                now()->addDay()
            );
        }

        list($profitableEnabledWells, $profitlessStoppedWells) = $proposedWells;

        $profitableWells = $this->buildSqlQueryWhereIn($profitableEnabledWells);

        $stoppedWells = $this->buildSqlQueryWhereIn($profitlessStoppedWells);

        $tableWellStatus = (new TechnicalWellStatus())->getTable();

        $tableWellLossStatus = (new TechnicalWellLossStatus())->getTable();

        return [
            'wellsSumByStatus' => $this->getWellsSumByStatus(
                $tableWellStatus,
                'status_id'
            ),
            'wellsSumByLossStatus' => $this->getWellsSumByStatus(
                $tableWellLossStatus,
                'loss_status_id'
            ),
            'wellsSum' => $this->getWellsSum(),
            'proposedWellsSum' => $this->getWellsSum(
                $profitableWells,
                $stoppedWells,
            ),
            'proposedWells' => $this->getWellsSum(
                $profitableWells,
                $stoppedWells,
                false
            ),
            'wells' => $this->getWellsSum(
                self::NULLABLE_WHERE_IN_PARAM,
                self::NULLABLE_WHERE_IN_PARAM,
                false
            ),
            'proposedStoppedWells' => $this->getProposedStoppedWells(
                $profitlessStoppedWells
            ),
            'profitlessWellsWithPrs' => $this->getProfitlessWellsWithPrs(
                $profitlessStoppedWells
            )
        ];
    }

    public function getWells(EconomicAnalysisWellRequest $request): array
    {
        $cacheKey = self::CACHE_BY_DATE_KEY . json_encode($request->validated(), true);

        if (Cache::has($cacheKey)) {
            return json_decode(Cache::get($cacheKey), true);
        }

        $proposedWells = $this->getProposedWells();

        list($profitableEnabledWells, $profitlessStoppedWells) = $proposedWells;

        $profitableUwis = $this->buildSqlQueryWhereIn($profitableEnabledWells);

        $stoppedUwis = $this->buildSqlQueryWhereIn($profitlessStoppedWells);

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableWellStatus = (new TechnicalWellStatus())->getTable();

        $tableWellLossStatus = (new TechnicalWellLossStatus)->getTable();

        $oilPropose = $this->sqlQueryOil($profitableUwis, $stoppedUwis);

        $liquidPropose = $this->sqlQueryLiquid($profitableUwis, $stoppedUwis);

        $netBack = $this->sqlQueryNetBack();

        $netBackPropose = $this->sqlQueryNetBack($profitableUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

        $overallExpendituresPropose = $this->sqlQueryOverallExpenditures($profitableUwis, $stoppedUwis);

        $changedStatus = $this->sqlQueryChangedStatus($profitableUwis, $stoppedUwis);

        $profitability = $this->sqlQueryProfitability();

        $dateMonth = $this->sqlQueryDateMonth();

        switch ($request->granularity) {
            case Granularity::MONTH:
                $date = "
                CASE WHEN well_forecast.status_id IS NOT NULL OR well_forecast.loss_status_id IS NOT NULL
	                 THEN well_forecast.date
	                 ELSE $dateMonth
                END";
                break;
            default:
                $date = "well_forecast.date";
                break;
        }

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi as uwi,
                $date as dt, 
                $dateMonth as dt_month, 
                $changedStatus as changed_status,               
                well_status.name as status_name, 
                well_loss_status.name as loss_status_name, 
                SUM(well_forecast.oil) as oil,
                SUM(well_forecast.oil_forecast) as oil_forecast,
                SUM($oilPropose) as oil_propose,    
                SUM(well_forecast.liquid) as liquid,
                SUM(well_forecast.liquid_forecast) as liquid_forecast,
                SUM($liquidPropose) as liquid_propose,
                SUM($netBack - ($overallExpenditures)) as operating_profit,
                SUM($netBackPropose - ($overallExpendituresPropose)) as operating_profit_propose
            "))
            ->leftjoin("$tableWellStatus AS well_status", function ($join) {
                /** @var JoinClause $join */
                $join->on("well_forecast.status_id", '=', 'well_status.id');
            })
            ->leftjoin("$tableWellLossStatus AS well_loss_status", function ($join) {
                /** @var JoinClause $join */
                $join->on("well_forecast.loss_status_id", '=', 'well_loss_status.id');
            })
            ->groupBy([
                "uwi",
                "dt",
                "dt_month",
                "status_name",
                "loss_status_name",
                "changed_status",
            ]);

        if ($request->uwi) {
            $query->whereRaw(DB::raw("well_forecast.uwi = '{$request->uwi}'"));
        }

        $query = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        $wells = DB::table(DB::raw("($query) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.dt as date,
                wells.dt_month as date_month,
                wells.status_name,
                wells.loss_status_name,
                wells.changed_status,
                wells.oil,
                wells.oil_forecast,
                wells.oil_propose,
                wells.liquid,
                wells.liquid_forecast,
                wells.liquid_propose,
                wells.operating_profit,
                wells.operating_profit_propose,
                $profitability as profitability
            "))
            ->groupByRaw(DB::raw("
                wells.uwi,
                wells.dt,
                wells.dt_month,
                wells.status_name,
                wells.loss_status_name,
                wells.changed_status,
                wells.oil,
                wells.oil_forecast,
                wells.oil_propose,
                wells.liquid,
                wells.liquid_forecast,
                wells.liquid_propose,
                wells.operating_profit,
                wells.operating_profit_propose,
                profitability
            "))
            ->get()
            ->toArray();

        Cache::put(
            $cacheKey,
            json_encode($wells, true),
            now()->addDay()
        );

        return $wells;
    }

    private function getWellsSum(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        bool $isSum = true
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $oil = $this->sqlQueryOil($profitableUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($profitableUwis, $stoppedUwis);

        $liquid = $this->sqlQueryLiquid($profitableUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($profitableUwis, $stoppedUwis);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis);

        $activeHours = $this->sqlQueryActiveHours($profitableUwis, $stoppedUwis);

        $pausedHours = $this->sqlQueryPausedHours($profitableUwis, $stoppedUwis);

        $netBack = $this->sqlQueryNetBack($profitableUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures($profitableUwis, $stoppedUwis);

        $profitability = $this->sqlQueryProfitability();

        $lossStatusCount = $this->sqlQueryLossStatusCount($profitableUwis, $stoppedUwis);

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                analysis_param.date as date,    
                analysis_param.netback_fact as netback_fact,    
                analysis_param.variable_cost as variable_cost,    
                analysis_param.permanent_cost as permanent_cost,    
                analysis_param.avg_prs_cost as avg_prs_cost,    
                analysis_param.oil_density as oil_density,    
                well_forecast.uwi as uwi,              
                SUM(well_forecast.active_hours + well_forecast.paused_hours) as total_hours,    
                SUM($activeHours) as active_hours,
                SUM($pausedHours) as paused_hours,
                SUM($oil) as oil,
                SUM($oilLoss) as oil_loss,
                SUM($liquid) as liquid,
                SUM($liquidLoss) as liquid_loss,
                SUM($prsPortion) as prs_portion,
                SUM($netBack) as netback,
                SUM($overallExpenditures) as overall_expenditures,
                SUM($netBack - ($overallExpenditures)) as operating_profit,
                SUM($lossStatusCount) as loss_status_count
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
            "date",
            "netback_fact",
            "variable_cost",
            "permanent_cost",
            "avg_prs_cost",
            "oil_density",
            "is_stopped",
            "profitability"
        ];

        if (!$isSum) {
            $columns[] = 'uwi';
        }

        $uwiQuery = $isSum ? 'COUNT(wells.uwi) as uwi_count' : 'wells.uwi';

        return DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.date,
                wells.netback_fact,
                wells.variable_cost,
                wells.permanent_cost,
                wells.avg_prs_cost,
                wells.oil_density,
                SUM(wells.oil) as oil,
                SUM(wells.oil_loss) as oil_loss,
                SUM(wells.liquid) as liquid,
                SUM(wells.liquid_loss) as liquid_loss,
                SUM(wells.active_hours) as active_hours,
                SUM(wells.paused_hours) as paused_hours,
                SUM(wells.total_hours) as total_hours,
                SUM(wells.prs_portion) as prs_portion,
                SUM(wells.prs_portion * wells.avg_prs_cost) as prs_cost,
                SUM(wells.netback) as netback,
                SUM(wells.overall_expenditures) as overall_expenditures,
                SUM(wells.operating_profit) as operating_profit,
                CASE WHEN wells.loss_status_count > 0
                     THEN 1
                     ELSE 0
                END as is_stopped,     
                $profitability as profitability,
                $uwiQuery
            "))
            ->groupBy($columns)
            ->orderBy("operating_profit")
            ->get()
            ->toArray();
    }

    private function getWellsSumByStatus(
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

        $activeHours = $this->sqlQueryActiveHours($profitableUwis, $stoppedUwis);

        $pausedHours = $this->sqlQueryPausedHours($profitableUwis, $stoppedUwis);

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                analysis_param.date as date,
                analysis_param.avg_prs_cost,
                well_forecast.uwi as uwi,
                well_status.id as status_id,    
                well_status.name as status_name,
                SUM($activeHours) as active_hours,
                SUM($pausedHours) as paused_hours,
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
                "avg_prs_cost",
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
                well_profitability.profitability_propose as profitability,
                COUNT(wells.uwi) AS uwi_count,
                SUM(wells.oil) AS oil,
                SUM(wells.oil_loss) AS oil_loss,
                SUM(wells.oil_forecast) AS oil_forecast,
                SUM(wells.liquid) AS liquid,
                SUM(wells.liquid_loss) AS liquid_loss,
                SUM(wells.active_hours) AS active_hours,
                SUM(wells.paused_hours) AS paused_hours,
                SUM(wells.total_hours) AS total_hours,
                SUM(wells.prs_portion) AS prs_portion,
                SUM(wells.prs_portion * wells.avg_prs_cost) AS prs_cost
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

    private function getProposedWells(): array
    {
        if (Cache::has(self::CACHE_KEY)) {
            return json_decode(Cache::get(self::CACHE_KEY), true);
        }

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


        $proposedWells = [];

        foreach ($profitableWellsByDate as $date => $profitableStoppedWells) {
            $profitlessWells = $this->getProfitlessWellsWithOil(
                $profitableStoppedWells['oil_loss'],
                $date
            );

            $profitlessStoppedWells = $this->getWellsForOilLimitWithMaxOperatingProfit(
                $profitlessWells,
                $profitableStoppedWells['oil_loss']
            );

            return [
                $profitableStoppedWells['uwis'],
                $profitlessStoppedWells['uwis']
            ];
        }

        return $proposedWells;
    }

    private function getProposedStoppedWells(array $stoppedUwis): array
    {
        $dateMonth = $this->sqlQueryDateMonth(null);

        return DB::table((new TechnicalWellForecast())->getTable())
            ->selectRaw(DB::raw("
                    $dateMonth as dt_month,
                    COUNT(DISTINCT uwi) as uwi_count,
                    SUM(oil) as oil_loss,
                    SUM(liquid) as liquid_loss,
                    SUM(active_hours + paused_hours) as paused_hours
                "))
            ->whereIn('uwi', $stoppedUwis)
            ->groupByRaw(DB::raw("dt_month"))
            ->get()
            ->toArray();
    }

    private function getProfitableStoppedWellsByDate(): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $lossStatuses = $this->sqlQueryLossStatuses(true);

        $query = DB::table("$tableWellForecast as well_forecast")
            ->select(DB::raw("
                well_forecast.uwi as uwi, 
                analysis_param.date as date,
                SUM(well_forecast.oil_loss) as oil_loss
            "))
            ->whereRaw(DB::raw("well_forecast.loss_status_id IN ($lossStatuses)"))
            ->groupBy(["uwi", "date"]);

        $wells = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.date,
                wells.oil_loss,
                well_profitability.profitability
            "))
            ->whereRaw(DB::raw("well_profitability.profitability = 'profitable'"));

        return $this
            ->sqlJoinWellProfitability(
                $query,
                'wells',
                'well_profitability'
            )
            ->get()
            ->toArray();
    }

    private function getProfitlessWellsWithOil(float $oilLoss, string $date): array
    {
        $oilLoss = abs($oilLoss);

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $netBack = $this->sqlQueryNetBack();

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

        $lossStatuses = $this->sqlQueryLossStatuses();

        $dateMonth = $this->sqlQueryDateMonth(null);

        $excludedUwis = DB::table($tableWellForecast)
            ->addSelect(DB::raw("DISTINCT uwi"))
            ->whereRaw(DB::raw("
                loss_status_id IN ($lossStatuses) AND
                $dateMonth = '$date'
            "))
            ->toSql();

        $query = DB::table("$tableWellForecast as well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi, 
                SUM(well_forecast.oil) as oil_sum,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->whereRaw(DB::raw("
                analysis_param.date = '$date' AND 
                well_forecast.uwi NOT IN ($excludedUwis)
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

    private function getProfitlessWellsWithPrs(array $stoppedUwis): array
    {
        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        $dateMonth = $this->sqlQueryDateMonth(null);

        $wells = DB::table((new TechnicalWellForecast())->getTable())
            ->selectRaw(DB::raw("
                uwi,
                SUM(oil) as oil,
                $dateMonth as dt_month,
                CASE WHEN uwi in ($stoppedUwis) 
                     THEN 1
                     ELSE 0
                END as is_stopped     
            "))
            ->whereRaw(DB::raw("prs_portion > 0"))
            ->groupByRaw(DB::raw("uwi, dt_month"))
            ->toSql();

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.dt_month as date,
                wells.is_stopped,
                CASE WHEN well_profitability.profitability = 'profitless' AND 
                          well_profitability.profitability_without_prs = 'profitable'
                     THEN 1
                     ELSE 0
                END as is_become_profitable,     
                COUNT(DISTINCT wells.uwi) as uwi_count,
                SUM(wells.oil) as oil,
                SUM(well_profitability.operating_profit) as operating_profit,
                SUM(well_profitability.operating_profit_propose) as operating_profit_propose,
                SUM(well_profitability.operating_profit_without_prs) as operating_profit_without_prs
            "))
            ->whereRaw(DB::raw("well_profitability.profitability = 'profitless'"))
            ->groupByRaw(DB::raw("wells.dt_month, wells.is_stopped, is_become_profitable"));

        return $this
            ->sqlJoinWellProfitability(
                $query,
                "wells",
                "well_profitability",
                self::NULLABLE_WHERE_IN_PARAM,
                self::NULLABLE_WHERE_IN_PARAM,
                "dt_month"
            )
            ->get()
            ->toArray();
    }

    private function getWellsForOilLimitWithMaxOperatingProfit(array $wells, float $oilLimit): array
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
        string $analysisParamAlias = 'analysis_param',
        bool $hasPrs = true
    ): string
    {
        $liquid = $this->sqlQueryLiquid($profitableUwis, $stoppedUwis, $wellForecastAlias);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis, $wellForecastAlias, $hasPrs);

        return "
        CASE WHEN $liquid > 0
             THEN $analysisParamAlias.permanent_cost
             ELSE $analysisParamAlias.permanent_stop_cost	
        END + 
        $liquid * $analysisParamAlias.variable_cost * $analysisParamAlias.oil_density / 1000 +
        $prsPortion * $analysisParamAlias.avg_prs_cost
        ";
    }

    private function sqlQueryLossStatusCount(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        $lossStatuses = $this->sqlQueryLossStatuses();

        return $profitableUwis === self::NULLABLE_WHERE_IN_PARAM && $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "CASE WHEN $wellForecastAlias.loss_status_id IN ($lossStatuses)
                    THEN 1
                    ELSE 0
               END"
            : "CASE WHEN $wellForecastAlias.uwi IN ($profitableUwis)
                    THEN 0
                    WHEN $wellForecastAlias.loss_status_id IN ($lossStatuses) OR 
                         $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 1
                    ELSE 0
               END";
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
                    THEN $wellForecastAlias.oil_forecast
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
        string $wellForecastAlias = 'well_forecast',
        bool $hasPrs = true
    ): string
    {
        if (!$hasPrs) {
            return "0";
        }

        return $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "$wellForecastAlias.prs_portion"
            : "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    ELSE $wellForecastAlias.prs_portion
               END";
    }

    private function sqlQueryActiveHours(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        return $profitableUwis === self::NULLABLE_WHERE_IN_PARAM && $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "$wellForecastAlias.active_hours"
            : "CASE WHEN $wellForecastAlias.uwi IN ($profitableUwis)
                    THEN 24
                    WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    ELSE $wellForecastAlias.active_hours
               END";
    }

    private function sqlQueryPausedHours(
        string $profitableUwis = "''",
        string $stoppedUwis = "''",
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        return $profitableUwis === self::NULLABLE_WHERE_IN_PARAM && $stoppedUwis === self::NULLABLE_WHERE_IN_PARAM
            ? "$wellForecastAlias.paused_hours"
            : "CASE WHEN $wellForecastAlias.uwi IN ($profitableUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 24
                    ELSE $wellForecastAlias.paused_hours
               END";
    }

    private function sqlQueryChangedStatus(
        string $profitableUwis,
        string $stoppedUwis,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        $lossStatuses = $this->sqlQueryLossStatuses();
        $lossStatusDeoptimization = TechnicalWellLossStatus::DEOPTIMIZATION;

        $statusNotChange = self::CHANGED_STATUS_NOT_CHANGE;
        $statusStop = self::CHANGED_STATUS_STOP;
        $statusLaunch = self::CHANGED_STATUS_LAUNCH;
        $statusDeoptimization = self::CHANGED_STATUS_DEOPTIMIZATION;

        return "
            CASE WHEN loss_status_id = $lossStatusDeoptimization AND 
                      $wellForecastAlias.uwi IN ($profitableUwis)
                 THEN $statusDeoptimization
                 WHEN $wellForecastAlias.uwi IN ($profitableUwis)
                 THEN $statusLaunch
                 WHEN $wellForecastAlias.loss_status_id IN ($lossStatuses) OR 
                      $wellForecastAlias.uwi IN ($stoppedUwis)
                 THEN $statusStop
                 ELSE $statusNotChange
            END";
    }

    private function sqlQueryProfitability(string $operatingProfit = 'operating_profit'): string
    {
        return "CASE WHEN $operatingProfit > 0 THEN 'profitable' ELSE 'profitless' END";
    }

    private function sqlQueryDateMonth(?string $wellForecastAlias = 'well_forecast'): string
    {
        $column = $wellForecastAlias ? "$wellForecastAlias.date" : "date";

        return "CAST(DATE_FORMAT($column, '%Y-%m-01') as DATE)";
    }

    private function sqlQueryLossStatuses(bool $hasDeoptimization = false): string
    {
        $statuses = TechnicalWellLossStatus::factualIds();

        if ($hasDeoptimization) {
            $statuses[] = TechnicalWellLossStatus::DEOPTIMIZATION;
        }

        return implode(",", $statuses);
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
        string $stoppedUwis = "''",
        string $joinDateKey = "date"
    ): Builder
    {
        $wells = $this
            ->builderWellProfitability($profitableUwis, $stoppedUwis)
            ->toSql();

        return $query->leftJoin(
            DB::raw("($wells) as $wellProfitabilityAlias"),
            function ($join) use ($wellAlias, $wellProfitabilityAlias, $joinDateKey) {
                /** @var JoinClause $join */
                $join
                    ->on("$wellProfitabilityAlias.uwi", "=", "$wellAlias.uwi")
                    ->on("$wellProfitabilityAlias.date", "=", "$wellAlias.$joinDateKey");
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

        $netBack = $this->sqlQueryNetBack();

        $netBackPropose = $this->sqlQueryNetBack($profitableUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

        $overallExpendituresPropose = $this->sqlQueryOverallExpenditures($profitableUwis, $stoppedUwis);

        $overallExpendituresWithoutPrs = $this->sqlQueryOverallExpenditures(
            $profitableUwis,
            $stoppedUwis,
            'well_forecast',
            'analysis_param',
            false
        );

        $profitability = $this->sqlQueryProfitability();

        $profitabilityPropose = $this->sqlQueryProfitability('operating_profit_propose');

        $profitabilityWithoutPrs = $this->sqlQueryProfitability('operating_profit_without_prs');

        $columns = ["uwi", "date"];

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi as uwi,
                analysis_param.date as date,
                SUM($netBack - ($overallExpenditures)) as operating_profit,
                SUM($netBackPropose - ($overallExpendituresPropose)) as operating_profit_propose,
                SUM($netBack - ($overallExpendituresWithoutPrs)) as operating_profit_without_prs
            "))
            ->groupBy($columns);

        $query = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        return DB::table(DB::raw("($query) as well_query"))
            ->addSelect($columns)
            ->addSelect(DB::raw("
                $profitability as profitability,
                $profitabilityPropose as profitability_propose,
                $profitabilityWithoutPrs as profitability_without_prs,
                SUM(operating_profit) as operating_profit,
                SUM(operating_profit_propose) as operating_profit_propose,
                SUM(operating_profit_without_prs) as operating_profit_without_prs
            "))
            ->groupBy(array_merge($columns, [
                'profitability',
                'profitability_propose',
                'profitability_without_prs'
            ]));
    }

}

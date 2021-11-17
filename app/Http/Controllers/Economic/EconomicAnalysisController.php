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

    const DEFAULT_WHERE_IN_PARAM = "''";

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

        list($enabledUwis, $stoppedUwis) = $proposedWells;

        return [
            'wellsSumByStatus' => $this->getWellsSumByStatus(
                (new TechnicalWellStatus())->getTable(),
                'status_id'
            ),
            'wellsSumByLossStatus' => $this->getWellsSumByStatus(
                (new TechnicalWellLossStatus())->getTable(),
                'loss_status_id'
            ),
            'wellsSum' => $this->getWellsSum(),
            'proposedWellsSum' => $this->getWellsSum($enabledUwis, $stoppedUwis),
            'proposedWells' => $this->getWellsSum($enabledUwis, $stoppedUwis, false),
            'wells' => $this->getWellsSum(null, null, false),
            'proposedStoppedWells' => $this->getProposedStoppedWells($stoppedUwis),
            'profitlessWellsWithPrs' => $this->getProfitlessWellsWithPrs($stoppedUwis),
            'analysisParams' => EcoRefsAnalysisParam::all()->toArray()
        ];
    }

    public function getWells(EconomicAnalysisWellRequest $request): array
    {
        $cacheKey = self::CACHE_BY_DATE_KEY . json_encode($request->validated(), true);

        if (Cache::has($cacheKey)) {
            return json_decode(Cache::get($cacheKey), true);
        }

        list($enabledUwis, $stoppedUwis) = $this->getProposedWells();

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableWellStatus = (new TechnicalWellStatus())->getTable();

        $tableWellLossStatus = (new TechnicalWellLossStatus)->getTable();

        $oilPropose = $this->sqlQueryOil($enabledUwis, $stoppedUwis);

        $liquidPropose = $this->sqlQueryLiquid($enabledUwis, $stoppedUwis);

        $netBack = $this->sqlQueryNetBack();

        $netBackPropose = $this->sqlQueryNetBack($enabledUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

        $overallExpendituresPropose = $this->sqlQueryOverallExpenditures($enabledUwis, $stoppedUwis);

        $changedStatus = $this->sqlQueryChangedStatus($enabledUwis, $stoppedUwis);

        $profitability = $this->sqlQueryProfitability();

        switch ($request->granularity) {
            case Granularity::MONTH:
                $date = "
                CASE WHEN well_forecast.status_id IS NOT NULL OR well_forecast.loss_status_id IS NOT NULL
	                 THEN well_forecast.date
	                 ELSE well_forecast.date_month
                END";
                break;
            default:
                $date = "well_forecast.date";
                break;
        }

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi as uwi,
                well_forecast.date_month as date_month, 
                $date as dt, 
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
                "date_month",
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
                wells.date_month as date_month,
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
                wells.date_month,
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
        array $enabledUwis = null,
        array $stoppedUwis = null,
        bool $isSum = true
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $oil = $this->sqlQueryOil($enabledUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($enabledUwis, $stoppedUwis);

        $liquid = $this->sqlQueryLiquid($enabledUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($enabledUwis, $stoppedUwis);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis);

        $activeHours = $this->sqlQueryActiveHours($enabledUwis, $stoppedUwis);

        $pausedHours = $this->sqlQueryPausedHours($enabledUwis, $stoppedUwis);

        $netBack = $this->sqlQueryNetBack($enabledUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures($enabledUwis, $stoppedUwis);

        $profitability = $this->sqlQueryProfitability();

        $lossStatusCount = $this->sqlQueryLossStatusCount($enabledUwis, $stoppedUwis);

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
        array $enabledUwis = null,
        array $stoppedUwis = null
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $oil = $this->sqlQueryOil($enabledUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($enabledUwis, $stoppedUwis);

        $liquid = $this->sqlQueryLiquid($enabledUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($enabledUwis, $stoppedUwis);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis);

        $activeHours = $this->sqlQueryActiveHours($enabledUwis, $stoppedUwis);

        $pausedHours = $this->sqlQueryPausedHours($enabledUwis, $stoppedUwis);

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                analysis_param.avg_prs_cost,
                well_forecast.uwi,
                well_forecast.date_month,
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
                "date_month",
                "avg_prs_cost",
                "uwi",
                "status_name",
                $joinKey
            ]);

        $wells = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        $netBack = $this->sqlQueryNetBack(
            null,
            null,
            'wells',
            'well_profitability',
            'wells.oil'
        );

        $overallExpenditures = $this->sqlQueryOverallExpenditures(
            null,
            null,
            'wells',
            'well_profitability',
            'wells.liquid',
            'wells.prs_portion'
        );

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.status_name,
                wells.status_id,
                wells.date_month,
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
                SUM(wells.prs_portion * wells.avg_prs_cost) AS prs_cost,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->groupByRaw(DB::raw("
                wells.date_month, 
                wells.status_name, 
                wells.status_id, 
                well_profitability.profitability_propose
            "));

        return $this
            ->sqlJoinWellProfitability(
                $query,
                'wells',
                'well_profitability',
                $enabledUwis,
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

            $date = $well['date_month'];

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
        return DB::table((new TechnicalWellForecast())->getTable())
            ->selectRaw(DB::raw("
                    date_month,
                    COUNT(DISTINCT uwi) as uwi_count,
                    SUM(oil) as oil_loss,
                    SUM(liquid) as liquid_loss,
                    SUM(active_hours + paused_hours) as paused_hours
                "))
            ->whereIn('uwi', $stoppedUwis)
            ->groupBy("date_month")
            ->get()
            ->toArray();
    }

    private function getProfitableStoppedWellsByDate(): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $lossStatuses = $this->sqlQueryLossStatuses(true);

        $wells = DB::table("$tableWellForecast as well_forecast")
            ->select(DB::raw("
                well_forecast.uwi, 
                well_forecast.date_month, 
                SUM(well_forecast.oil_loss) as oil_loss
            "))
            ->whereRaw(DB::raw("well_forecast.loss_status_id IN ($lossStatuses)"))
            ->groupBy(["uwi", "date_month"])
            ->toSql();

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.date_month,
                wells.oil_loss
            "))
            ->whereRaw(DB::raw("well_profitability.profitability = 'profitable'"));

        return $this
            ->sqlJoinWellProfitability($query)
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

        $excludedUwis = DB::table($tableWellForecast)
            ->addSelect(DB::raw("DISTINCT uwi"))
            ->whereRaw(DB::raw("
                date_month = '$date' AND
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
                well_forecast.date_month = '$date' AND
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

        $wells = DB::table((new TechnicalWellForecast())->getTable())
            ->selectRaw(DB::raw("
                uwi,
                date_month,
                SUM(oil) as oil,
                CASE WHEN uwi in ($stoppedUwis) 
                     THEN 1
                     ELSE 0
                END as is_stopped     
            "))
            ->whereRaw(DB::raw("prs_portion > 0"))
            ->groupByRaw(DB::raw("uwi, date_month"))
            ->toSql();

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.date_month as date_month,
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
                SUM(well_profitability.operating_profit_stop) as operating_profit_stop
            "))
            ->whereRaw(DB::raw("well_profitability.profitability = 'profitless'"))
            ->groupByRaw(DB::raw("
                wells.date_month, 
                wells.is_stopped, 
                is_become_profitable
            "));

        return $this
            ->sqlJoinWellProfitability($query)
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
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param',
        string $oil = null
    ): string
    {
        if ($oil === null) {
            $oil = $this->sqlQueryOil($enabledUwis, $stoppedUwis, $wellForecastAlias);
        }

        return "$oil * $analysisParamAlias.netback_fact / 1000";
    }

    private function sqlQueryOverallExpenditures(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param',
        string $liquid = null,
        string $prsPortion = null
    ): string
    {
        if ($liquid === null) {
            $liquid = $this->sqlQueryLiquid($enabledUwis, $stoppedUwis, $wellForecastAlias);
        }

        if ($prsPortion === null) {
            $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis, $wellForecastAlias);
        }

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
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        $lossStatuses = $this->sqlQueryLossStatuses();

        if (!$enabledUwis && !$stoppedUwis) {
            return "CASE WHEN $wellForecastAlias.loss_status_id IN ($lossStatuses)
                         THEN 1
                         ELSE 0
                    END";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN 0
                    WHEN $wellForecastAlias.loss_status_id IN ($lossStatuses) OR 
                         $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 1
                    ELSE 0
               END";
    }

    private function sqlQueryOil(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.oil";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN $wellForecastAlias.oil_forecast
                    ELSE $wellForecastAlias.oil
               END";
    }

    private function sqlQueryOilLoss(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.oil_loss";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN $wellForecastAlias.oil
                    ELSE $wellForecastAlias.oil_loss
               END";
    }

    private function sqlQueryLiquid(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.liquid";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN $wellForecastAlias.liquid_forecast
                    ELSE $wellForecastAlias.liquid
               END";
    }

    private function sqlQueryLiquidLoss(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.liquid_loss";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN $wellForecastAlias.liquid
                    ELSE $wellForecastAlias.liquid_loss
               END";
    }

    private function sqlQueryPrsPortion(
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$stoppedUwis) {
            return "$wellForecastAlias.prs_portion";
        }

        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    ELSE $wellForecastAlias.prs_portion
               END";
    }

    private function sqlQueryActiveHours(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.active_hours";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN 24
                    WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 0
                    ELSE $wellForecastAlias.active_hours
               END";
    }

    private function sqlQueryPausedHours(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.paused_hours";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN 0
                    WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 24
                    ELSE $wellForecastAlias.paused_hours
               END";
    }

    private function sqlQueryChangedStatus(
        array $enabledUwis,
        array $stoppedUwis,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);
        $stoppedUwis = $this->buildSqlQueryWhereIn($stoppedUwis);

        $lossStatuses = $this->sqlQueryLossStatuses();
        $lossStatusDeoptimization = TechnicalWellLossStatus::DEOPTIMIZATION;

        $statusNotChange = self::CHANGED_STATUS_NOT_CHANGE;
        $statusStop = self::CHANGED_STATUS_STOP;
        $statusLaunch = self::CHANGED_STATUS_LAUNCH;
        $statusDeoptimization = self::CHANGED_STATUS_DEOPTIMIZATION;

        return "
            CASE WHEN loss_status_id = $lossStatusDeoptimization AND 
                      $wellForecastAlias.uwi IN ($enabledUwis)
                 THEN $statusDeoptimization
                 WHEN $wellForecastAlias.uwi IN ($enabledUwis)
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
                DB::raw("$wellForecastAlias.date_month"),
                '=',
                DB::raw("$analysisParamAlias.date")
            );
        });
    }

    private function sqlJoinWellProfitability(
        Builder $query,
        string $wellAlias = "wells",
        string $wellProfitabilityAlias = "well_profitability",
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $joinDateKey = "date_month"
    ): Builder
    {
        $wells = $this
            ->builderWellProfitability($enabledUwis, $stoppedUwis)
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

    private function buildSqlQueryWhereIn(array $stringParams = null): string
    {
        return $stringParams
            ? "'" . implode("','", $stringParams) . "'"
            : self::DEFAULT_WHERE_IN_PARAM;
    }

    private function builderWellProfitability(
        array $enabledUwis = null,
        array $stoppedUwis = null
    ): Builder
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $netBack = $this->sqlQueryNetBack();

        $netBackPropose = $this->sqlQueryNetBack($enabledUwis, $stoppedUwis);

        $netBackStop = $this->sqlQueryNetBack(
            null,
            null,
            "well_forecast",
            "analysis_param",
            "0"
        );

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

        $overallExpendituresPropose = $this->sqlQueryOverallExpenditures(
            $enabledUwis,
            $stoppedUwis
        );

        $overallExpendituresWithoutPrs = $this->sqlQueryOverallExpenditures(
            null,
            null,
            "well_forecast",
            "analysis_param",
            null,
            "0"
        );

        $overallExpendituresStop = $this->sqlQueryOverallExpenditures(
            null,
            null,
            "well_forecast",
            "analysis_param",
            "0",
            "0"
        );

        $profitability = $this->sqlQueryProfitability();

        $profitabilityPropose = $this->sqlQueryProfitability('operating_profit_propose');

        $profitabilityWithoutPrs = $this->sqlQueryProfitability('operating_profit_without_prs');

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi,
                analysis_param.date,
                analysis_param.netback_fact,
                analysis_param.permanent_cost,
                analysis_param.permanent_stop_cost,
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
                analysis_param.permanent_stop_cost,
                analysis_param.variable_cost,
                analysis_param.avg_prs_cost,
                analysis_param.oil_density
            "));

        $wells = $this
            ->sqlJoinAnalysisParam($query)
            ->toSql();

        return DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.date,
                wells.netback_fact,
                wells.permanent_cost,
                wells.permanent_stop_cost,
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
                wells.permanent_stop_cost,
                wells.variable_cost,
                wells.avg_prs_cost,
                wells.oil_density,
                profitability,
                profitability_propose,
                profitability_without_prs
            "));
    }

}

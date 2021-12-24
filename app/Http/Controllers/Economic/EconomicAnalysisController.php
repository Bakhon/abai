<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Analysis\EconomicAnalysisDataRequest;
use App\Http\Requests\Economic\Analysis\EconomicAnalysisWellByGranularityRequest;
use App\Http\Requests\Economic\Analysis\EconomicAnalysisWellByKitRequest;
use App\Jobs\Economic\Technical\TechnicalWellForecastKitJob;
use App\Models\Refs\EcoRefsAnalysisParam;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellForecastKit;
use App\Models\Refs\TechnicalWellForecastKitResult;
use App\Models\Refs\TechnicalWellLossStatus;
use App\Models\Refs\TechnicalWellStatus;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Level23\Druid\Types\Granularity;

class EconomicAnalysisController extends Controller
{
    const CACHE_DELIMITER = '_';
    const CACHE_DAYS = 1;
    const CACHE_KEY_WELLS_KIT = 'economic_analysis_wells_kit';

    const CHANGED_STATUS_NOT_CHANGE = 0;
    const CHANGED_STATUS_STOP = -1;
    const CHANGED_STATUS_LAUNCH = 1;
    const CHANGED_STATUS_DEOPTIMIZATION = 2;

    public function __construct()
    {
        $this
            ->middleware('can:economic view main')
            ->only(
                'index',
                'indexWells',
                'inputParams',
                'getData',
                'getWellsByGranularity',
                'getWellsByKit',
            );
    }

    public function index(): View
    {
        return view('economic.analysis.index');
    }

    public function inputParams(): View
    {
        return view('economic.analysis.input_params');
    }

    public function indexWells(): View
    {
        return view('economic.analysis.wells');
    }

    public function getData(EconomicAnalysisDataRequest $request): array
    {
        $kits = TechnicalWellForecastKit::query()
            ->whereIn('id', $request->kit_ids)
            ->with(['results' => function ($q) use ($request) {
                $q->wherePermanentStopCoefficient($request->permanent_stop_coefficient);
            }])
            ->get();

        $data = [
            'analysisParams' => EcoRefsAnalysisParam::query()
                ->whereIn('log_id', $kits->pluck('economic_log_id'))
                ->get()
                ->toArray(),
            'dollarRate' => [
                'value' => EconomicOptimizationController::getDollarRate() ?? '0',
                'url' => EconomicOptimizationController::DOLLAR_RATE_URL
            ],
            'oilPrice' => [
                'value' => EconomicOptimizationController::getOilPrice() ?? '0',
                'url' => EconomicOptimizationController::OIL_PRICE_URL
            ],
            'wellsByKits' => []
        ];

        foreach ($kits as $kit) {
            $data['wellsByKits'][$kit->id] = $this->getWellsKit(
                $kit,
                $kit->results->first()
            );
        }

        return $data;
    }

    public function getWellsByGranularity(EconomicAnalysisWellByGranularityRequest $request): array
    {
        $kits = TechnicalWellForecastKit::query()
            ->whereIn('id', $request->kit_ids)
            ->with(['results' => function ($q) use ($request) {
                $q->wherePermanentStopCoefficient($request->permanent_stop_coefficient);
            }])
            ->get();

        $wells = [];

        foreach ($kits as $kit) {
            $wells[$kit->id] = $this->getWellsKitByGranularity(
                $kit,
                $kit->results->first(),
                $request->granularity,
                $request->uwi
            );
        }

        return $wells;
    }

    public function getWellsByKit(EconomicAnalysisWellByKitRequest $request): array
    {
        $kit = TechnicalWellForecastKit::findOrFail($request->kit_id);

        $result = $kit
            ->results()
            ->wherePermanentStopCoefficient($request->permanent_stop_coefficient)
            ->firstOrFail();

        return [
            'proposedWells' => $this->getWellsSum(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $result->permanent_stop_coefficient,
                $result->enabled_uwis,
                $result->stopped_uwis,
                false
            ),
            'wells' => $this->getWellsSum(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $result->permanent_stop_coefficient,
                null,
                null,
                false
            ),
        ];
    }

    private function getWellsKit(
        TechnicalWellForecastKit $kit,
        TechnicalWellForecastKitResult $result
    ): array
    {
        $cacheKey = $this->cacheKey(
            self::CACHE_KEY_WELLS_KIT,
            [$kit->id, $result->permanent_stop_coefficient]
        );

        if (Cache::has($cacheKey)) {
            return json_decode(Cache::get($cacheKey), true);
        }

        $wellsKit = [
            'wellsSumByStatus' => $this->getWellsSumByStatus(
                (new TechnicalWellStatus())->getTable(),
                'status_id',
                $kit->economic_log_id,
                $kit->technical_log_id,
                $result->permanent_stop_coefficient
            ),
            'wellsSumByLossStatus' => $this->getWellsSumByStatus(
                (new TechnicalWellLossStatus())->getTable(),
                'loss_status_id',
                $kit->economic_log_id,
                $kit->technical_log_id,
                $result->permanent_stop_coefficient
            ),
            'wellsSum' => $this->getWellsSum(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $result->permanent_stop_coefficient
            ),
            'proposedWellsSum' => $this->getWellsSum(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $result->permanent_stop_coefficient,
                $result->enabled_uwis,
                $result->stopped_uwis
            ),
            'proposedStoppedWells' => $this->getProposedStoppedWells(
                $kit->technical_log_id,
                $result->stopped_uwis
            ),
            'profitlessWellsWithPrs' => $this->getProfitlessWellsWithPrs(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $result->permanent_stop_coefficient,
                $result->stopped_uwis
            ),
        ];

        Cache::put($cacheKey, json_encode($wellsKit, true), $this->cacheTime());

        return $wellsKit;
    }

    private function getWellsKitByGranularity(
        TechnicalWellForecastKit $kit,
        TechnicalWellForecastKitResult $result,
        string $granularity,
        string $uwi = null
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableWellStatus = (new TechnicalWellStatus())->getTable();

        $tableWellLossStatus = (new TechnicalWellLossStatus)->getTable();

        $oilPropose = TechnicalWellForecastKitJob::sqlQueryOil(
            $result->enabled_uwis,
            $result->stopped_uwis
        );

        $liquidPropose = TechnicalWellForecastKitJob::sqlQueryLiquid(
            $result->enabled_uwis,
            $result->stopped_uwis
        );

        $netBack = TechnicalWellForecastKitJob::sqlQueryNetBack();

        $netBackPropose = TechnicalWellForecastKitJob::sqlQueryNetBack(
            $result->enabled_uwis,
            $result->stopped_uwis
        );

        $overallExpenditures = TechnicalWellForecastKitJob::sqlQueryOverallExpenditures(
            $result->permanent_stop_coefficient
        );

        $overallExpendituresPropose = TechnicalWellForecastKitJob::sqlQueryOverallExpenditures(
            $result->permanent_stop_coefficient,
            $result->enabled_uwis,
            $result->stopped_uwis
        );

        $changedStatus = $this->sqlQueryChangedStatus(
            $result->enabled_uwis,
            $result->stopped_uwis
        );

        $profitability = TechnicalWellForecastKitJob::sqlQueryProfitability();

        switch ($granularity) {
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

        $technicalLogId = $kit->technical_log_id;

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
            ->whereRaw(DB::raw("well_forecast.log_id = $technicalLogId"))
            ->groupBy([
                "uwi",
                "dt",
                "date_month",
                "status_name",
                "loss_status_name",
                "changed_status",
            ]);

        if ($uwi) {
            $query->whereRaw(DB::raw("well_forecast.uwi = '$uwi'"));
        }

        $query = TechnicalWellForecastKitJob::sqlJoinAnalysisParam($query, $kit->economic_log_id)->toSql();

        return DB::table(DB::raw("($query) as wells"))
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
    }

    private function getWellsSum(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
        array $enabledUwis = null,
        array $stoppedUwis = null,
        bool $isSum = true
    ): array
    {
        $oil = TechnicalWellForecastKitJob::sqlQueryOil($enabledUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($enabledUwis, $stoppedUwis);

        $liquid = TechnicalWellForecastKitJob::sqlQueryLiquid($enabledUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($enabledUwis, $stoppedUwis);

        $prsPortion = TechnicalWellForecastKitJob::sqlQueryPrsPortion($stoppedUwis);

        $activeHours = $this->sqlQueryActiveHours($enabledUwis, $stoppedUwis);

        $pausedHours = $this->sqlQueryPausedHours($enabledUwis, $stoppedUwis);

        $netBack = TechnicalWellForecastKitJob::sqlQueryNetBack(
            $enabledUwis,
            $stoppedUwis
        );

        $overallExpenditures = TechnicalWellForecastKitJob::sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            $enabledUwis,
            $stoppedUwis
        );

        $profitability = TechnicalWellForecastKitJob::sqlQueryProfitability();

        $lossStatusCount = $this->sqlQueryLossStatusCount($enabledUwis, $stoppedUwis);

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $wells = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi,              
                well_forecast.date_month,  
                SUM(well_forecast.active_hours + well_forecast.paused_hours) as total_hours,    
                SUM(oil_forecast) as oil_forecast,
                SUM(liquid_forecast) as liquid_forecast,
                SUM($activeHours) as active_hours,
                SUM($pausedHours) as paused_hours,
                SUM($oil) as oil,
                SUM($oilLoss) as oil_loss,
                SUM($liquid) as liquid,
                SUM($liquidLoss) as liquid_loss,
                SUM($prsPortion) as prs_portion,
                SUM($lossStatusCount) as loss_status_count
            "))
            ->whereRaw(DB::raw("well_forecast.log_id = $technicalLogId"))
            ->groupBy([
                "uwi",
                "date_month"
            ])
            ->toSql();

        $query = DB::table(DB::raw("($wells) AS well_forecast"))
            ->addSelect(DB::raw("
                analysis_param.netback_fact as netback_fact,    
                analysis_param.variable_cost as variable_cost,    
                analysis_param.permanent_cost as permanent_cost,    
                analysis_param.avg_prs_cost as avg_prs_cost,    
                analysis_param.oil_density as oil_density,    
                well_forecast.uwi,              
                well_forecast.date_month as date,  
                well_forecast.total_hours,              
                well_forecast.active_hours,              
                well_forecast.paused_hours,              
                well_forecast.oil,              
                well_forecast.oil_loss,              
                well_forecast.liquid,              
                well_forecast.liquid_loss,              
                well_forecast.prs_portion,              
                well_forecast.loss_status_count,              
                SUM($netBack) as netback,
                SUM($overallExpenditures) as overall_expenditures,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->groupBy([
                "uwi",
                "date_month",
                "total_hours",
                "active_hours",
                "paused_hours",
                "oil",
                "oil_loss",
                "liquid",
                "liquid_loss",
                "prs_portion",
                "loss_status_count",
                "netback_fact",
                "variable_cost",
                "permanent_cost",
                "avg_prs_cost",
                "oil_density",
            ]);

        $wells = TechnicalWellForecastKitJob::sqlJoinAnalysisParam($query, $economicLogId)->toSql();

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
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
        array $enabledUwis = null,
        array $stoppedUwis = null
    ): array
    {
        $oil = TechnicalWellForecastKitJob::sqlQueryOil($enabledUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($enabledUwis, $stoppedUwis);

        $oilTechLoss = $this->sqlQueryOilTechLoss($enabledUwis, $stoppedUwis);

        $liquid = TechnicalWellForecastKitJob::sqlQueryLiquid($enabledUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($enabledUwis, $stoppedUwis);

        $liquidTechLoss = $this->sqlQueryLiquidTechLoss($enabledUwis, $stoppedUwis);

        $prsPortion = TechnicalWellForecastKitJob::sqlQueryPrsPortion($stoppedUwis);

        $activeHours = $this->sqlQueryActiveHours($enabledUwis, $stoppedUwis);

        $pausedHours = $this->sqlQueryPausedHours($enabledUwis, $stoppedUwis);

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $wells = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.$joinKey,
                well_forecast.date_month,
                well_forecast.uwi,
                SUM(well_forecast.active_hours + well_forecast.paused_hours) as total_hours,
                SUM(well_forecast.oil_forecast) as oil_forecast,
                SUM($activeHours) as active_hours,
                SUM($pausedHours) as paused_hours,
                SUM($oil) as oil,
                SUM($oilLoss) as oil_loss,
                SUM($oilTechLoss) as oil_tech_loss,
                SUM($liquid) as liquid,
                SUM($liquidLoss) as liquid_loss,
                SUM($liquidTechLoss) as liquid_tech_loss,
                SUM($prsPortion) as prs_portion
            "))
            ->whereRaw(DB::raw("log_id = $technicalLogId AND $joinKey IS NOT NULL"))
            ->groupBy([
                $joinKey,
                "date_month",
                "uwi",
            ])
            ->orderByRaw(DB::raw("date_month, uwi"))
            ->toSql();

        $netBack = TechnicalWellForecastKitJob::sqlQueryNetBack(
            null,
            null,
            'wells',
            'well_profitability',
            'wells.oil'
        );

        $netBackTechLoss = TechnicalWellForecastKitJob::sqlQueryNetBack(
            null,
            null,
            'wells',
            'well_profitability',
            'wells.oil_tech_loss'
        );

        $overallExpenditures = TechnicalWellForecastKitJob::sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            null,
            null,
            'wells',
            'well_profitability',
            'wells.liquid',
            'wells.prs_portion'
        );

        $query = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.$joinKey as status_id,
                wells.date_month,
                well_profitability.profitability_propose as profitability,
                COUNT(wells.uwi) AS uwi_count,
                SUM(wells.oil) AS oil,
                SUM(wells.oil_loss) AS oil_loss,
                SUM(wells.oil_tech_loss) AS oil_tech_loss,
                SUM(wells.oil_forecast) AS oil_forecast,
                SUM(wells.liquid) AS liquid,
                SUM(wells.liquid_loss) AS liquid_loss,
                SUM(wells.liquid_tech_loss) AS liquid_tech_loss,
                SUM(wells.active_hours) AS active_hours,
                SUM(wells.paused_hours) AS paused_hours,
                SUM(wells.total_hours) AS total_hours,
                SUM(wells.prs_portion) AS prs_portion,
                SUM(wells.prs_portion * well_profitability.avg_prs_cost) AS prs_cost,
                SUM($netBack - ($overallExpenditures)) as operating_profit,
                SUM(
                $netBackTechLoss -
                wells.liquid_tech_loss * well_profitability.variable_cost * well_profitability.oil_density / 1000
                ) as operating_profit_tech_loss
            "))
            ->groupByRaw(DB::raw("
                $joinKey,
                wells.date_month,
                well_profitability.profitability_propose
            "));

        $wellsByStatus = TechnicalWellForecastKitJob::sqlJoinWellProfitability(
            $query,
            $economicLogId,
            $technicalLogId,
            $permanentStopCoefficient,
            'wells',
            'well_profitability',
            $enabledUwis,
            $stoppedUwis
        )
            ->get()
            ->toArray();

        $statuses = DB::table($tableWellStatus)->get();

        foreach ($wellsByStatus as &$wellByStatus) {
            $wellByStatus = (array)$wellByStatus;

            $wellByStatus['status_name'] = $statuses
                ->firstWhere("id", $wellByStatus["status_id"])
                ->name;
        }

        return $wellsByStatus;
    }

    private function getProposedStoppedWells(
        int $technicalLogId,
        array $stoppedUwis
    ): array
    {
        return DB::table((new TechnicalWellForecast())->getTable())
            ->selectRaw(DB::raw("
                    date_month,
                    COUNT(DISTINCT uwi) as uwi_count,
                    SUM(oil) as oil_loss,
                    SUM(liquid) as liquid_loss,
                    SUM(active_hours + paused_hours) as paused_hours
                "))
            ->where('log_id', $technicalLogId)
            ->whereIn('uwi', $stoppedUwis)
            ->groupBy("date_month")
            ->get()
            ->toArray();
    }

    private function getProfitlessWellsWithPrs(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
        array $stoppedUwis
    ): array
    {
        $stoppedUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($stoppedUwis);

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
            ->whereRaw(DB::raw("log_id = $technicalLogId AND prs_portion > 0"))
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

        return TechnicalWellForecastKitJob::sqlJoinWellProfitability(
            $query,
            $economicLogId,
            $technicalLogId,
            $permanentStopCoefficient
        )
            ->get()
            ->toArray();
    }

    private function sqlQueryLossStatusCount(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        $lossStatuses = TechnicalWellForecastKitJob::sqlQueryLossStatuses();

        if (!$enabledUwis && !$stoppedUwis) {
            return "CASE WHEN $wellForecastAlias.loss_status_id IN ($lossStatuses)
                         THEN 1
                         ELSE 0
                    END";
        }

        $enabledUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                    THEN 0
                    WHEN $wellForecastAlias.loss_status_id IN ($lossStatuses) OR 
                         $wellForecastAlias.uwi IN ($stoppedUwis)
                    THEN 1
                    ELSE 0
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

        $enabledUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                     THEN 0
                     WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                     THEN $wellForecastAlias.oil
                     ELSE $wellForecastAlias.oil_loss
               END";
    }

    private function sqlQueryOilTechLoss(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.oil_tech_loss";
        }

        $enabledUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($enabledUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                     THEN 0
                     ELSE $wellForecastAlias.oil_tech_loss
               END";
    }

    private function sqlQueryLiquidTechLoss(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.liquid_tech_loss";
        }

        $enabledUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($enabledUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                     THEN 0
                     ELSE $wellForecastAlias.liquid_tech_loss
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

        $enabledUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($stoppedUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                     THEN 0
                     WHEN $wellForecastAlias.uwi IN ($stoppedUwis)
                     THEN $wellForecastAlias.liquid
                     ELSE $wellForecastAlias.liquid_loss
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

        $enabledUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($stoppedUwis);

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

        $enabledUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($enabledUwis);

        $stoppedUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($stoppedUwis);

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
        $enabledUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($enabledUwis);
        $stoppedUwis = TechnicalWellForecastKitJob::buildSqlQueryWhereIn($stoppedUwis);

        $lossStatuses = TechnicalWellForecastKitJob::sqlQueryLossStatuses();
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

    private function cacheKey(string $cacheName, array $params): string
    {
        return $cacheName . implode(self::CACHE_DELIMITER, $params);
    }

    private function cacheTime(): Carbon
    {
        return now()->addDays(self::CACHE_DAYS);
    }
}

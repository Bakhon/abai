<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Analysis\EconomicAnalysisDataRequest;
use App\Http\Requests\Economic\Analysis\EconomicAnalysisWellByGranularityRequest;
use App\Http\Requests\Economic\Analysis\EconomicAnalysisWellByKitRequest;
use App\Models\Refs\EcoRefsAnalysisParam;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellForecastKit;
use App\Models\Refs\TechnicalWellLossStatus;
use App\Models\Refs\TechnicalWellStatus;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Level23\Druid\Types\Granularity;
use SplFixedArray;

class EconomicAnalysisController extends Controller
{
    const CACHE_DELIMITER = '_';
    const CACHE_DAYS = 1;
    const CACHE_KEY_PROPOSED_WELLS = 'economic_analysis_proposed_wells';
    const CACHE_KEY_WELLS_KIT = 'economic_analysis_wells_kit';
    const CACHE_KEY_WELLS_BY_GRANULARITY = 'economic_analysis_wells_by_granularity';

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

    public function getData(EconomicAnalysisDataRequest $request): array
    {
        $kits = TechnicalWellForecastKit::query()
            ->whereIn('id', $request->kit_ids)
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
                $request->permanent_stop_coefficient
            );
        }

        return $data;
    }

    public function getWellsByGranularity(EconomicAnalysisWellByGranularityRequest $request): array
    {
        $kits = TechnicalWellForecastKit::query()
            ->whereIn('id', $request->kit_ids)
            ->get();

        $wells = [];

        foreach ($kits as $kit) {
            $wells[$kit->id] = $this->getWellsKitByGranularity(
                $kit,
                $request->permanent_stop_coefficient,
                $request->granularity,
                $request->uwi
            );
        }

        return $wells;
    }

    public function getWellsByKit(EconomicAnalysisWellByKitRequest $request): array
    {
        $kit = TechnicalWellForecastKit::findOrFail($request->kit_id);

        $permanentStopCoefficient = $request->permanent_stop_coefficient;

        list($enabledUwis, $stoppedUwis) = $this->getProposedWells(
            $kit->economic_log_id,
            $kit->technical_log_id,
            $permanentStopCoefficient
        );

        return [
            'proposedWells' => $this->getWellsSum(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $permanentStopCoefficient,
                $enabledUwis,
                $stoppedUwis,
                false
            ),
            'wells' => $this->getWellsSum(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $permanentStopCoefficient,
                null,
                null,
                false
            ),
        ];
    }

    private function getWellsKit(
        TechnicalWellForecastKit $kit,
        float $permanentStopCoefficient
    ): array
    {
        $cacheKey = $this->cacheKey(
            self::CACHE_KEY_WELLS_KIT,
            [$kit->economic_log_id, $kit->technical_log_id, $permanentStopCoefficient]
        );

        if (Cache::has($cacheKey)) {
            return json_decode(Cache::get($cacheKey), true);
        }

        list($enabledUwis, $stoppedUwis) = $this->getProposedWells(
            $kit->economic_log_id,
            $kit->technical_log_id,
            $permanentStopCoefficient
        );

        $wellsKit = [
            'wellsSumByStatus' => $this->getWellsSumByStatus(
                (new TechnicalWellStatus())->getTable(),
                'status_id',
                $kit->economic_log_id,
                $kit->technical_log_id,
                $permanentStopCoefficient
            ),
            'wellsSumByLossStatus' => $this->getWellsSumByStatus(
                (new TechnicalWellLossStatus())->getTable(),
                'loss_status_id',
                $kit->economic_log_id,
                $kit->technical_log_id,
                $permanentStopCoefficient
            ),
            'wellsSum' => $this->getWellsSum(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $permanentStopCoefficient
            ),
            'proposedWellsSum' => $this->getWellsSum(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $permanentStopCoefficient,
                $enabledUwis,
                $stoppedUwis
            ),
            'proposedStoppedWells' => $this->getProposedStoppedWells(
                $kit->technical_log_id,
                $stoppedUwis
            ),
            'profitlessWellsWithPrs' => $this->getProfitlessWellsWithPrs(
                $kit->economic_log_id,
                $kit->technical_log_id,
                $permanentStopCoefficient,
                $stoppedUwis
            ),
        ];

        Cache::put($cacheKey, json_encode($wellsKit, true), $this->cacheTime());

        return $wellsKit;
    }

    private function getWellsKitByGranularity(
        TechnicalWellForecastKit $kit,
        float $permanentStopCoefficient,
        string $granularity,
        string $uwi = null
    ): array
    {
        $cacheKey = $this->cacheKey(
            self::CACHE_KEY_WELLS_BY_GRANULARITY,
            [$kit->economic_log_id, $kit->technical_log_id, $permanentStopCoefficient, $granularity]
        );

        if (!$uwi && Cache::has($cacheKey)) {
            return json_decode(Cache::get($cacheKey), true);
        }

        list($enabledUwis, $stoppedUwis) = $this->getProposedWells(
            $kit->economic_log_id,
            $kit->technical_log_id,
            $permanentStopCoefficient
        );

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableWellStatus = (new TechnicalWellStatus())->getTable();

        $tableWellLossStatus = (new TechnicalWellLossStatus)->getTable();

        $oilPropose = $this->sqlQueryOil($enabledUwis, $stoppedUwis);

        $liquidPropose = $this->sqlQueryLiquid($enabledUwis, $stoppedUwis);

        $netBack = $this->sqlQueryNetBack();

        $netBackPropose = $this->sqlQueryNetBack($enabledUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures(
            $permanentStopCoefficient
        );

        $overallExpendituresPropose = $this->sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            $enabledUwis,
            $stoppedUwis
        );

        $changedStatus = $this->sqlQueryChangedStatus($enabledUwis, $stoppedUwis);

        $profitability = $this->sqlQueryProfitability();

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

        $query = $this
            ->sqlJoinAnalysisParam($query, $kit->economic_log_id)
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

        if (!$uwi) {
            Cache::put($cacheKey, json_encode($wells, true), $this->cacheTime());
        }

        return $wells;
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
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $oil = $this->sqlQueryOil($enabledUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($enabledUwis, $stoppedUwis);

        $liquid = $this->sqlQueryLiquid($enabledUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($enabledUwis, $stoppedUwis);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis);

        $activeHours = $this->sqlQueryActiveHours($enabledUwis, $stoppedUwis);

        $pausedHours = $this->sqlQueryPausedHours($enabledUwis, $stoppedUwis);

        $netBack = $this->sqlQueryNetBack($enabledUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            $enabledUwis,
            $stoppedUwis
        );

        $profitability = $this->sqlQueryProfitability();

        $lossStatusCount = $this->sqlQueryLossStatusCount($enabledUwis, $stoppedUwis);

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.date_month as date,  
                well_forecast.uwi as uwi,              
                analysis_param.netback_fact as netback_fact,    
                analysis_param.variable_cost as variable_cost,    
                analysis_param.permanent_cost as permanent_cost,    
                analysis_param.avg_prs_cost as avg_prs_cost,    
                analysis_param.oil_density as oil_density,    
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
            ->whereRaw(DB::raw("well_forecast.log_id = $technicalLogId"))
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
            ->sqlJoinAnalysisParam($query, $economicLogId)
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
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
        array $enabledUwis = null,
        array $stoppedUwis = null
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $oil = $this->sqlQueryOil($enabledUwis, $stoppedUwis);

        $oilLoss = $this->sqlQueryOilLoss($enabledUwis, $stoppedUwis);

        $oilTechLoss = $this->sqlQueryOilTechLoss($enabledUwis, $stoppedUwis);

        $liquid = $this->sqlQueryLiquid($enabledUwis, $stoppedUwis);

        $liquidLoss = $this->sqlQueryLiquidLoss($enabledUwis, $stoppedUwis);

        $liquidTechLoss = $this->sqlQueryLiquidTechLoss($enabledUwis, $stoppedUwis);

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
                SUM($oilTechLoss) as oil_tech_loss,
                SUM($liquid) as liquid,
                SUM($liquidLoss) as liquid_loss,
                SUM($liquidTechLoss) as liquid_tech_loss,
                SUM($prsPortion) as prs_portion
            "))
            ->leftjoin("$tableWellStatus AS well_status", function ($join) use ($joinKey) {
                /** @var JoinClause $join */
                $join->on("well_forecast.$joinKey", '=', 'well_status.id');
            })
            ->whereRaw(DB::raw("
                well_forecast.log_id = $technicalLogId AND $joinKey IS NOT NULL
            "))
            ->groupBy([
                "date_month",
                "avg_prs_cost",
                "uwi",
                "status_name",
                $joinKey
            ]);

        $wells = $this
            ->sqlJoinAnalysisParam($query, $economicLogId)
            ->toSql();

        $netBack = $this->sqlQueryNetBack(
            null,
            null,
            'wells',
            'well_profitability',
            'wells.oil'
        );

        $netBackTechLoss = $this->sqlQueryNetBack(
            null,
            null,
            'wells',
            'well_profitability',
            'wells.oil_tech_loss'
        );

        $overallExpenditures = $this->sqlQueryOverallExpenditures(
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
                wells.status_name,
                wells.status_id,
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
                SUM(wells.prs_portion * wells.avg_prs_cost) AS prs_cost,
                SUM($netBack - ($overallExpenditures)) as operating_profit,
                SUM(
                $netBackTechLoss - 
                wells.liquid_tech_loss * well_profitability.variable_cost * well_profitability.oil_density / 1000
                ) as operating_profit_tech_loss
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
    }

    private function getProposedWells(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient
    ): array
    {
        $cacheKey = $this->cacheKey(
            self::CACHE_KEY_PROPOSED_WELLS,
            [$economicLogId, $technicalLogId, $permanentStopCoefficient]
        );

        if (Cache::has($cacheKey)) {
            return json_decode(Cache::get($cacheKey), true);
        }

        $profitableStoppedWells = $this->getProfitableStoppedWellsByDate(
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

        $profitlessWells = $this->getProfitlessWellsWithOil(
            $economicLogId,
            $technicalLogId,
            $permanentStopCoefficient,
            $profitableOilLoss,
        );

        $profitlessStoppedWells = $this->getWellsForOilLimitWithMaxOperatingProfit(
            $profitlessWells,
            $profitableOilLoss
        );

        $proposedWells = [
            $profitableUwis,
            $profitlessStoppedWells['uwis']
        ];

        Cache::put($cacheKey, json_encode($proposedWells, true), $this->cacheTime());

        return $proposedWells;
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
            ->whereIn('uwi', $stoppedUwis)
            ->where('log_id', $technicalLogId)
            ->groupBy("date_month")
            ->get()
            ->toArray();
    }

    private function getProfitableStoppedWellsByDate(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient
    ): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $lossStatuses = $this->sqlQueryLossStatuses(true);

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

        return $this
            ->sqlJoinWellProfitability(
                $query,
                $economicLogId,
                $technicalLogId,
                $permanentStopCoefficient
            )
            ->get()
            ->toArray();
    }

    private function getProfitlessWellsWithOil(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
        float $oilLoss
    ): array
    {
        $oilLoss = abs($oilLoss);

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $netBack = $this->sqlQueryNetBack();

        $overallExpenditures = $this->sqlQueryOverallExpenditures(
            $permanentStopCoefficient
        );

        $lossStatuses = $this->sqlQueryLossStatuses();

        $excludedUwis = DB::table($tableWellForecast)
            ->addSelect(DB::raw("DISTINCT uwi"))
            ->whereRaw(DB::raw("
                loss_status_id IN ($lossStatuses) AND
                log_id = $technicalLogId
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

        return $this
            ->sqlJoinAnalysisParam($query, $economicLogId)
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

        return $this
            ->sqlJoinWellProfitability(
                $query,
                $economicLogId,
                $technicalLogId,
                $permanentStopCoefficient
            )
            ->get()
            ->toArray();
    }

    private function getWellsForOilLimitWithMaxOperatingProfit(
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
            $liquid = $this->sqlQueryLiquid($enabledUwis, $stoppedUwis, $wellForecastAlias);
        }

        if ($prsPortion === null) {
            $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis, $wellForecastAlias);
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

    private function sqlQueryOilTechLoss(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.oil_tech_loss";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

        return "CASE WHEN $wellForecastAlias.uwi IN ($enabledUwis)
                     THEN 0
                     ELSE $wellForecastAlias.oil_tech_loss
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

    private function sqlQueryLiquidTechLoss(
        array $enabledUwis = null,
        array $stoppedUwis = null,
        string $wellForecastAlias = 'well_forecast'
    ): string
    {
        if (!$enabledUwis && !$stoppedUwis) {
            return "$wellForecastAlias.liquid_tech_loss";
        }

        $enabledUwis = $this->buildSqlQueryWhereIn($enabledUwis);

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
        int $economicLogId,
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param'
    ): Builder
    {
        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        return $query->leftjoin(
            "$tableAnalysisParam AS $analysisParamAlias",
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

    private function sqlJoinWellProfitability(
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
        $wells = $this
            ->builderWellProfitability(
                $economicLogId,
                $technicalLogId,
                $permanentStopCoefficient,
                $enabledUwis,
                $stoppedUwis
            )
            ->toSql();

        return $query->leftJoin(
            DB::raw("($wells) as $wellProfitabilityAlias"),
            function ($join) use ($wellAlias, $wellProfitabilityAlias) {
                /** @var JoinClause $join */
                $join
                    ->on("$wellProfitabilityAlias.uwi", "=", "$wellAlias.uwi")
                    ->on("$wellProfitabilityAlias.date", "=", "$wellAlias.date_month");
            });
    }

    private function buildSqlQueryWhereIn(array $stringParams = null): string
    {
        return $stringParams
            ? "'" . implode("','", $stringParams) . "'"
            : self::DEFAULT_WHERE_IN_PARAM;
    }

    private function builderWellProfitability(
        int $economicLogId,
        int $technicalLogId,
        float $permanentStopCoefficient,
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

        $overallExpenditures = $this->sqlQueryOverallExpenditures(
            $permanentStopCoefficient
        );

        $overallExpendituresPropose = $this->sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            $enabledUwis,
            $stoppedUwis
        );

        $overallExpendituresWithoutPrs = $this->sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
            null,
            null,
            "well_forecast",
            "analysis_param",
            null,
            "0"
        );

        $overallExpendituresStop = $this->sqlQueryOverallExpenditures(
            $permanentStopCoefficient,
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
                analysis_param.variable_cost,
                analysis_param.avg_prs_cost,
                analysis_param.oil_density,
                SUM($netBack - ($overallExpenditures)) as operating_profit,
                SUM($netBack - ($overallExpendituresWithoutPrs)) as operating_profit_without_prs,
                SUM($netBackPropose - ($overallExpendituresPropose)) as operating_profit_propose,
                SUM($netBackStop - ($overallExpendituresStop)) as operating_profit_stop
            "))
            ->whereRaw(DB::raw("well_forecast.log_id = $technicalLogId"))
            ->groupByRaw(DB::raw("
                well_forecast.uwi,
                analysis_param.date,
                analysis_param.netback_fact,
                analysis_param.permanent_cost,
                analysis_param.variable_cost,
                analysis_param.avg_prs_cost,
                analysis_param.oil_density
            "));

        $wells = $this
            ->sqlJoinAnalysisParam($query, $economicLogId)
            ->toSql();

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
            "));
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

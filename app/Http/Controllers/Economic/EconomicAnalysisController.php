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
        list($profitableWells, $stoppedWells) = $this->getProposedWells();

        $profitableWells = $this->buildSqlQueryWhereIn($profitableWells);

        $stoppedWells = $this->buildSqlQueryWhereIn($stoppedWells);

        $tableWellStatus = (new TechnicalWellStatus())->getTable();

        $tableWellLossStatus = (new TechnicalWellLossStatus())->getTable();

        return [
            'wells' => $this->getSumWellsParams(),
            'wellsByStatus' => $this->getSumWellsParamsByStatus(
                $tableWellStatus,
                'status_id'
            ),
            'wellsByLossStatus' => $this->getSumWellsParamsByStatus(
                $tableWellLossStatus,
                'loss_status_id'
            ),
            'proposedWellsByStatus' => $this->getSumWellsParamsByStatus(
                $tableWellStatus,
                'status_id',
                $profitableWells,
                $stoppedWells
            ),
            'proposedWellsByLossStatus' => $this->getSumWellsParamsByStatus(
                $tableWellLossStatus,
                'loss_status_id',
                $profitableWells,
                $stoppedWells
            ),
        ];
    }

    private function getSumWellsParams(): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        $netBack = $this->sqlQueryNetBack();

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

        $profitability = $this->sqlQueryProfitability();

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                analysis_param.date as date,    
                analysis_param.netback_fact as netback_fact,    
                analysis_param.variable_cost as variable_cost,    
                analysis_param.permanent_cost as permanent_cost,    
                analysis_param.avg_prs_cost as avg_prs_cost,    
                analysis_param.oil_density as oil_density,    
                well_forecast.uwi as uwi,    
                SUM(well_forecast.oil) as oil,
                SUM(well_forecast.oil_loss) as oil_loss,
                SUM(well_forecast.liquid) as liquid,
                SUM(well_forecast.liquid_loss) as liquid_loss,
                SUM(well_forecast.active_hours) as active_hours,
                SUM(well_forecast.paused_hours) as paused_hours,
                SUM(well_forecast.prs_portion) as prs_portion,
                SUM(well_forecast.active_hours + well_forecast.paused_hours) as total_hours,
                SUM($netBack) as netback,
                SUM($overallExpenditures) as overall_expenditures,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->leftjoin("$tableAnalysisParam AS analysis_param", function ($join) {
                /** @var JoinClause $join */
                $join
                    ->on(
                        DB::raw('MONTH(well_forecast.date)'),
                        '=',
                        DB::raw('MONTH(analysis_param.date)')
                    )->on(
                        DB::raw('YEAR(well_forecast.date)'),
                        '=',
                        DB::raw('YEAR(analysis_param.date)')
                    );
            })
            ->groupBy([
                "uwi",
                "date",
                "netback_fact",
                "variable_cost",
                "permanent_cost",
                "avg_prs_cost",
                "oil_density",
            ])
            ->toSql();

        $columns = [
            "date",
            "netback_fact",
            "variable_cost",
            "permanent_cost",
            "avg_prs_cost",
            "oil_density",
        ];

        return DB::table(DB::raw("($query) as well_query"))
            ->addSelect($columns)
            ->addSelect(DB::raw("
                SUM(oil) as oil,
                SUM(oil_loss) as oil_loss,
                SUM(liquid) as liquid,
                SUM(liquid_loss) as liquid_loss,
                SUM(active_hours) as active_hours,
                SUM(paused_hours) as paused_hours,
                SUM(total_hours) as total_hours,
                SUM(prs_portion) as prs_portion,
                SUM(netback) as netback,
                SUM(overall_expenditures) as overall_expenditures,
                SUM(operating_profit) as operating_profit,
                COUNT(uwi) as uwi_count,
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

        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        $oil = $this->sqlQueryOil($profitableUwis, $stoppedUwis);

        $liquid = $this->sqlQueryLiquid($profitableUwis, $stoppedUwis);

        $prsPortion = $this->sqlQueryPrsPortion($stoppedUwis);

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                analysis_param.date as date,
                well_forecast.uwi as uwi,
                well_status.id as status_id,    
                well_status.name as status_name,
                SUM(well_forecast.liquid_loss) as liquid_loss,
                SUM(well_forecast.active_hours) as active_hours,
                SUM(well_forecast.paused_hours) as paused_hours,
                SUM(well_forecast.active_hours + well_forecast.paused_hours) as total_hours,    
                SUM(well_forecast.oil_forecast) as oil_forecast,
                SUM(well_forecast.oil_loss) as oil_loss,
                SUM($oil) as oil,
                SUM($liquid) as liquid,
                SUM($prsPortion) as prs_portion
            "))
            ->leftjoin("$tableAnalysisParam AS analysis_param", function ($join) {
                /** @var JoinClause $join */
                $join
                    ->on(
                        DB::raw('MONTH(well_forecast.date)'),
                        '=',
                        DB::raw('MONTH(analysis_param.date)')
                    )->on(
                        DB::raw('YEAR(well_forecast.date)'),
                        '=',
                        DB::raw('YEAR(analysis_param.date)')
                    );
            })
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
            ])
            ->toSql();

        $wellsByProfitability = $this
            ->builderWellsByProfitability($profitableUwis, $stoppedUwis)
            ->toSql();

        return DB::table(DB::raw("($query) as wells"))
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
            ->leftJoin(DB::raw("($wellsByProfitability) as well_profitability"), function ($join) {
                /** @var JoinClause $join */
                $join
                    ->on("well_profitability.uwi", "=", "wells.uwi")
                    ->on("well_profitability.date", "=", "wells.date");
            })
            ->groupBy([
                "date",
                "status_name",
                "status_id",
                "profitability",
            ])
            ->get()
            ->toArray();
    }

    public function getProposedWells(): array
    {
        $profitableWellsByDate = $this->getProfitableWellsWithOilLossByDate();

        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        $netBack = $this->sqlQueryNetBack();

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

        foreach ($profitableWellsByDate as $date => $profitableWells) {
            $oilLoss = abs($profitableWells['oil_loss']);

            $wells = DB::table("$tableWellForecast as well_forecast")
                ->addSelect(DB::raw("
                    well_forecast.uwi, 
                    SUM(well_forecast.oil) as oil_sum,
                    SUM($netBack - ($overallExpenditures)) as operating_profit
                "))
                ->leftjoin("$tableAnalysisParam AS analysis_param", function ($join) {
                    /** @var JoinClause $join */
                    $join
                        ->on(
                            DB::raw('MONTH(well_forecast.date)'),
                            '=',
                            DB::raw('MONTH(analysis_param.date)')
                        )->on(
                            DB::raw('YEAR(well_forecast.date)'),
                            '=',
                            DB::raw('YEAR(analysis_param.date)')
                        );
                })
                ->havingRaw(DB::raw("oil_sum > 0 and oil_sum <= $oilLoss"))
                ->groupBy("uwi")
                ->orderBy("operating_profit")
                ->get()
                ->toArray();

            foreach ($wells as &$well) {
                $well = (array)$well;

                $well['weight'] = -$well['operating_profit'];

                $well['oil'] = (int)ceil($well['oil_sum'] * self::OIL_FACTOR);
            }

            $wells = $this->getBestWellsForOilLimit(
                (int)floor($oilLoss * self::OIL_FACTOR),
                $wells
            );

            $stoppedWells = [
                'uwis' => [],
                'oil' => 0,
                'operating_profit' => 0
            ];

            foreach ($wells as $well) {
                $stoppedWells['uwis'][] = $well['uwi'];

                $stoppedWells['oil'] = $well['oil_sum'];

                $stoppedWells['operating_profit'] = $well['operating_profit'];
            }

            return [$profitableWells['uwis'], $stoppedWells['uwis']];
        }
    }

    private function getProfitableWellsWithOilLossByDate(): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        $lossStatuses = implode(",", self::OIL_LOSS_STATUSES);

        $wells = DB::table("$tableWellForecast as well_forecast")
            ->select(DB::raw("
                well_forecast.uwi as uwi, 
                analysis_param.date as date,
                SUM(well_forecast.oil) as oil,
                SUM(well_forecast.oil_loss) as oil_loss,
                SUM(well_forecast.oil_forecast) as oil_forecast
                "
            ))
            ->whereRaw("well_forecast.status_id IN ($lossStatuses)")
            ->leftjoin("$tableAnalysisParam AS analysis_param", function ($join) {
                /** @var JoinClause $join */
                $join
                    ->on(
                        DB::raw('MONTH(well_forecast.date)'),
                        '=',
                        DB::raw('MONTH(analysis_param.date)')
                    )->on(
                        DB::raw('YEAR(well_forecast.date)'),
                        '=',
                        DB::raw('YEAR(analysis_param.date)')
                    );
            })
            ->groupBy(["uwi", "date"])
            ->toSql();

        $wellsByProfitability = $this
            ->builderWellsByProfitability()
            ->toSql();

        $wells = DB::table(DB::raw("($wells) as wells"))
            ->addSelect(DB::raw("
                wells.uwi,
                wells.date,
                wells.oil,
                wells.oil_loss,
                wells.oil_forecast,
                well_profitability.profitability
            "))
            ->leftJoin(DB::raw("($wellsByProfitability) as well_profitability"), function ($join) {
                /** @var JoinClause $join */
                $join
                    ->on("well_profitability.uwi", "=", "wells.uwi")
                    ->on("well_profitability.date", "=", "wells.date");
            })
            ->whereRaw(DB::raw("well_profitability.profitability = 'profitable'"))
            ->get()
            ->toArray();

        $wellsByDate = [];

        foreach ($wells as $well) {
            $well = (array)$well;

            $date = $well['date'];

            if (!isset($wellsByDate[$date])) {
                $wellsByDate[$date] = [
                    'oil_loss' => 0,
                    'uwis' => []
                ];
            }

            $oilLoss = (float)$well['oil_loss'];

            if ($oilLoss > 0 || $oilLoss < 0) {
                $wellsByDate[$date]['oil_loss'] += $oilLoss;

                $wellsByDate[$date]['uwis'][] = $well["uwi"];
            }
        }

        return $wellsByDate;
    }

    private function getBestWellsForOilLimit(int $limit, array $wells): array
    {
        $wellsCount = count($wells);

        $table = new SplFixedArray($wellsCount + 1);

        for ($j = 0; $j < $wellsCount + 1; $j++) {
            $table[$j] = new SplFixedArray($limit + 1);
        }

        for ($j = 1; $j <= $wellsCount; $j += 1) {
            for ($w = 1; $w <= $limit; $w += 1) {
                $table[$j][$w] = $wells[$j - 1]['oil'] > $w
                    ? $table[$j - 1][$w]
                    : max(
                        $table[$j - 1][$w],
                        $table[$j - 1][$w - $wells[$j - 1]['oil']] + $wells[$j - 1]['weight']
                    );
            }
        }

        $result = [];

        $j = $wellsCount;

        while ($j > 0) {
            if ($table[$j][$limit] !== $table[$j - 1][$limit]) {
                $result[] = $wells[$j - 1];

                $limit -= $wells[$j - 1]['oil'];
            }

            $j -= 1;
        }

        return $result;
    }

    private function builderWellsByProfitability(
        string $profitableUwis = "''",
        string $stoppedUwis = "''"
    ): Builder
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        $netBack = $this->sqlQueryNetBack($profitableUwis, $stoppedUwis);

        $overallExpenditures = $this->sqlQueryOverallExpenditures($profitableUwis, $stoppedUwis);

        $profitability = $this->sqlQueryProfitability();

        $columns = ["uwi", "date"];

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_forecast.uwi as uwi,
                analysis_param.date as date,
                SUM($netBack - ($overallExpenditures)) as operating_profit
            "))
            ->leftjoin("$tableAnalysisParam AS analysis_param", function ($join) {
                /** @var JoinClause $join */
                $join
                    ->on(
                        DB::raw('MONTH(well_forecast.date)'),
                        '=',
                        DB::raw('MONTH(analysis_param.date)')
                    )->on(
                        DB::raw('YEAR(well_forecast.date)'),
                        '=',
                        DB::raw('YEAR(analysis_param.date)')
                    );
            })
            ->groupBy($columns)
            ->toSql();

        return DB::table(DB::raw("($query) as well_query"))
            ->addSelect($columns)
            ->addSelect(DB::raw("$profitability as profitability"))
            ->groupBy(array_merge($columns, ['profitability']));
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

    private function sqlQueryProfitability(): string
    {
        return "CASE WHEN operating_profit > 0 THEN 'profitable' ELSE 'profitless' END";
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

    private function buildSqlQueryWhereIn(array $stringParams): string
    {
        return $stringParams
            ? "'" . implode("','", $stringParams) . "'"
            : self::NULLABLE_WHERE_IN_PARAM;
    }
}

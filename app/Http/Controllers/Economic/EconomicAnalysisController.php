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

class EconomicAnalysisController extends Controller
{
    protected $druidClient;
    protected $structureService;

    const TABLE_WELL_FORECAST = 'well_forecast';

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
        return [
            'wells' => $this->getSumWellsParams(),
            'wellsByStatus' => $this->getSumWellsParamsByStatus(
                (new TechnicalWellStatus())->getTable(),
                'status_id'
            ),
            'wellsByLossStatus' => $this->getSumWellsParamsByStatus(
                (new TechnicalWellLossStatus())->getTable(),
                'loss_status_id'
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
            ]);

        $columns = [
            "date",
            "netback_fact",
            "variable_cost",
            "permanent_cost",
            "avg_prs_cost",
            "oil_density",
        ];

        $query = $query->toSql();

        return DB::table(DB::raw("($query) as temp_query"))
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

    private function getSumWellsParamsByStatus(string $tableWellStatus, string $joinKey): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        $query = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                analysis_param.date as date,
                well_forecast.uwi as uwi,
                well_status.id as status_id,    
                well_status.name as status_name,    
                SUM(well_forecast.oil) as oil,
                SUM(well_forecast.oil_loss) as oil_loss,
                SUM(well_forecast.liquid) as liquid,
                SUM(well_forecast.liquid_loss) as liquid_loss,
                SUM(well_forecast.active_hours) as active_hours,
                SUM(well_forecast.paused_hours) as paused_hours,
                SUM(well_forecast.prs_portion) as prs_portion,
                SUM(well_forecast.active_hours + well_forecast.paused_hours) as total_hours
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
            ->builderWellsByProfitability()
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
                SUM(wells.liquid) AS liquid,
                SUM(wells.liquid_loss) AS liquid_loss,
                SUM(wells.active_hours) AS active_hours,
                SUM(wells.paused_hours) AS paused_hours,
                SUM(wells.total_hours) AS total_hours,
                SUM(wells.prs_portion) AS prs_portion
            "))
            ->leftJoin(DB::raw("($wellsByProfitability) as well_profitability"), function ($join) {
                /** @var JoinClause $join */
                $join->on("well_profitability.uwi", "=", "wells.uwi");
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

    private function builderWellsByProfitability(): Builder
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        $netBack = $this->sqlQueryNetBack();

        $overallExpenditures = $this->sqlQueryOverallExpenditures();

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
            ->groupBy($columns);

        $query = $query->toSql();

        return DB::table(DB::raw("($query) as well_query"))
            ->addSelect($columns)
            ->addSelect(DB::raw("$profitability as profitability"))
            ->groupBy(array_merge($columns, ['profitability']));
    }

    private function sqlQueryNetBack(
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param'
    ): string
    {
        return "$wellForecastAlias.oil * $analysisParamAlias.netback_fact / 1000";
    }

    private function sqlQueryOverallExpenditures(
        string $wellForecastAlias = 'well_forecast',
        string $analysisParamAlias = 'analysis_param'
    ): string
    {
        return "
        CASE WHEN $wellForecastAlias.liquid > 0
        THEN $analysisParamAlias.permanent_cost
        ELSE $analysisParamAlias.variable_stop_cost_fact	
        END + 
        $wellForecastAlias.liquid * $analysisParamAlias.variable_cost * $analysisParamAlias.oil_density / 1000 +
        $wellForecastAlias.prs_portion * $analysisParamAlias.avg_prs_cost
        ";
    }

    private function sqlQueryProfitability(): string
    {
        return "CASE WHEN operating_profit > 0 THEN 'profitable' ELSE 'profitless' END";
    }
}

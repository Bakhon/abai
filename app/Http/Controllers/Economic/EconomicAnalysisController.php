<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Models\Refs\EcoRefsAnalysisParam;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellLossStatus;
use App\Models\Refs\TechnicalWellStatus;
use App\Services\BigData\StructureService;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Level23\Druid\DruidClient;

class EconomicAnalysisController extends Controller
{
    protected $druidClient;
    protected $structureService;

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
            'wellsByStatuses' => $this->getWellsByStatus(
                (new TechnicalWellStatus())->getTable(),
                'status_id'
            ),
            'wellsByLossStatuses' => $this->getWellsByStatus(
                (new TechnicalWellLossStatus())->getTable(),
                'loss_status_id'
            ),
        ];
    }

    private function getWellsByStatus(string $tableWellStatus, string $joinKey): array
    {
        $tableWellForecast = (new TechnicalWellForecast())->getTable();

        $tableAnalysisParam = (new EcoRefsAnalysisParam())->getTable();

        $wells = DB::table("$tableWellForecast AS well_forecast")
            ->addSelect(DB::raw("
                well_status.id as status_id,    
                well_status.name as status_name,    
                analysis_param.date as date,    
                analysis_param.netback_fact as netback_fact,    
                analysis_param.variable_cost as variable_cost,    
                analysis_param.permanent_cost as permanent_cost,    
                analysis_param.avg_prs_cost as avg_prs_cost,    
                analysis_param.oil_density as oil_density,    
                SUM(well_forecast.oil) as oil,
                SUM(well_forecast.oil_loss) as oil_loss,
                SUM(well_forecast.liquid) as liquid,
                SUM(well_forecast.liquid_loss) as liquid_loss,
                SUM(well_forecast.active_hours) as active_hours,
                SUM(well_forecast.paused_hours) as paused_hours,
                SUM(well_forecast.prs_portion) as prs_portion,
                COUNT(distinct well_forecast.uwi) as uwi_count,
                CASE WHEN 
                     well_forecast.oil * analysis_param.netback_fact -
                     analysis_param.permanent_cost -
                     well_forecast.liquid * analysis_param.variable_cost / analysis_param.oil_density -
                     analysis_param.avg_prs_cost * well_forecast.prs_portion > 0 
                THEN 'profitable'
                ELSE 'profitless'
                END as profitability
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
                $joinKey,
                "status_name",
                "netback_fact",
                "variable_cost",
                "permanent_cost",
                "avg_prs_cost",
                "oil_density",
                "profitability",
            ])
            ->get()
            ->toArray();

        foreach ($wells as &$well) {
            $well = (array)$well;

            $well['netback'] = $well['oil'] * $well['netback_fact'];

            $well['overall_expenditures'] = $well['permanent_cost'] +
                $well['liquid'] * $well['variable_cost'] / $well['oil_density'] +
                $well['avg_prs_cost'] * $well['prs_portion'];

            $well['operating_profit'] = $well['netback'] - $well['overall_expenditures'];

            $well['total_hours'] = $well['active_hours'] + $well['paused_hours'];
        }

        return $wells;
    }
}

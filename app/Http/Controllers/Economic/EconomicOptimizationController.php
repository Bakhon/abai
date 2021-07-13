<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Level23\Druid\DruidClient;

class EconomicOptimizationController extends Controller
{
    protected $druidClient;

    const DATA_SOURCE = 'economic_scenario_test_v1';

    const OPTIMIZED_COLUMNS = [
        "Revenue_total",
        "Overall_expenditures",
        "operating_profit_12m",
        "oil",
        "liquid",
        "prs",
        "well_count",
        "well_count_profitable",
        "well_count_profitless_cat_1",
        "well_count_profitless_cat2",
    ];

    const OPTIMIZED_COLUMN_SUFFIX = '_optimize';

    public function __construct(DruidClient $druidClient)
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'getData');

        $this->druidClient = $druidClient;
    }

    public function index()
    {
        return view('economic.optimization');
    }

    public function getData(Request $request)
    {
        EconomicNrsController::validateAccess($request->org_id);

        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE)
            ->interval(EconomicNrsController::calcIntervalYears());

        $columns = [
            "scenario_id",
            "percent_stop_cat1",
            "percent_stop_cat2",
            "coef_Fixed_nopayroll",
            "coef_cost_WR_payroll",
            "dollar_rate",
            "oil_price",
        ];

        foreach (self::OPTIMIZED_COLUMNS as $column) {
            $columns[] = $column;

            $columns[] = $column . self::OPTIMIZED_COLUMN_SUFFIX;
        }

        $data = $builder
            ->select($columns)
            ->groupBy()
            ->data()[0];

        $result = [];

        foreach (self::OPTIMIZED_COLUMNS as $column) {
            $columnOptimized = $column . self::OPTIMIZED_COLUMN_SUFFIX;

            $result[] = [
                $column => [
                    'value' => EconomicNrsController::moneyFormat($data[$column]),
                    'value_optimized' => EconomicNrsController::moneyFormat($data[$columnOptimized]),
                    'percent' => EconomicNrsController::percentFormat($data[$column], $data[$columnOptimized]),
                    'original_value' => $data[$column],
                    'original_value_optimized' => $data[$columnOptimized],
                ]
            ];
        }

        return $result;
    }
}

<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;

class EconomicOptimizationController extends Controller
{
    protected $druidClient;

    const DATA_SOURCE = 'economic_scenario_test_v1';

    const DATA_SOURCE_DATE = '2021/07/13';

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
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(EconomicNrsController::intervalFormat(
                Carbon::parse(self::DATA_SOURCE_DATE),
                Carbon::parse(self::DATA_SOURCE_DATE)->addDay(),
            ));

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
            ->data();

        $result = [];

        foreach ($data as $index => $item) {
            foreach ($columns as $column) {
                $result[$index][$column] = $item[$column];
            }

            foreach (self::OPTIMIZED_COLUMNS as $column) {
                $columnOptimized = $column . self::OPTIMIZED_COLUMN_SUFFIX;

                $result[$index][$column] = [
                    'value' => EconomicNrsController::moneyFormat($item[$column]),
                    'value_optimized' => EconomicNrsController::moneyFormat($item[$columnOptimized]),
                    'percent' => EconomicNrsController::percentFormat($item[$column], $item[$columnOptimized]),
                    'original_value' => $item[$column],
                    'original_value_optimized' => $item[$columnOptimized],
                ];
            }

        }

        return $result;
    }
}

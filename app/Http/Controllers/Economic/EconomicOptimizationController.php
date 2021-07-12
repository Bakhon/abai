<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Models\Refs\Org;
use Illuminate\Http\Request;
use Level23\Druid\DruidClient;

class EconomicOptimizationController extends Controller
{
    protected $druidClient;

    const DATA_SOURCE = 'economic_2020v18_test';

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

        /** @var Org $org */
        $org = Org::findOrFail($request->org_id);

        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE)
            ->interval(EconomicNrsController::calcIntervalYears());

        if ($org->druid_id) {
            $builder->where('org_id2', '=', $org->druid_id);
        }

        $data = $builder
            ->sum("Revenue_total")
            ->sum("Overall_expenditures")
            ->sum("Operating_profit")
            ->longSum("oil")
            ->longSum("liquid")
            ->longSum("prs")
            ->count('uwi')
            ->groupBy()
            ->data()[0];

        $uwiCat1Count = $builder
            ->where('profitability', '=', EconomicNrsController::PROFITABILITY_CAT_1)
            ->count('uwi')
            ->groupBy()
            ->data()[0];

        $uwiCat2Count = $builder
            ->where('profitability', '=', EconomicNrsController::PROFITABILITY_CAT_2)
            ->count('uwi')
            ->groupBy()
            ->data()[0];

        return [
            'Revenue_total' => [
                'sum' => [
                    'value' => EconomicNrsController::moneyFormat($data["Revenue_total"]),
                    'value_optimized' => EconomicNrsController::moneyFormat($data["Revenue_total"]),
                    'percent' => EconomicNrsController::percentFormat($data["Revenue_total"], $data["Revenue_total"]),
                ],
            ],
            'Overall_expenditures' => [
                'sum' => [
                    'value' => EconomicNrsController::moneyFormat($data["Overall_expenditures"]),
                    'value_optimized' => EconomicNrsController::moneyFormat($data["Overall_expenditures"]),
                    'percent' => EconomicNrsController::percentFormat($data["Overall_expenditures"], $data["Overall_expenditures"]),
                ],
            ],
            'Operating_profit' => [
                'sum' => [
                    'value' => EconomicNrsController::moneyFormat($data["Operating_profit"]),
                    'value_optimized' => EconomicNrsController::moneyFormat($data["Operating_profit"]),
                    'percent' => EconomicNrsController::percentFormat($data["Operating_profit"], $data["Operating_profit"]),
                ],
            ],
            'uwi' => [
                'cat1' => $uwiCat1Count,
                'cat2' => $uwiCat2Count
            ]
        ];
    }
}

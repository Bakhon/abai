<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DruidController;
use DateTime;
use Illuminate\Http\JsonResponse;
use Level23\Druid\DruidClient;
use Level23\Druid\Extractions\ExtractionBuilder;
use Level23\Druid\Types\Granularity;

class GTMController extends Controller
{

    const ACCUM_OIL_PROD_FACT_DATA_FIELD = 'add_prod_12m';
    const ACCUM_OIL_PROD_PLAN_DATA_FIELD = 'plan_add_prod_12m';

    /**
     * @var DruidClient
     */
    private $druidClient;

    /**
     * @var DruidController
     */
    private $druidController;

    public function __construct()
    {
        $this->middleware('can:paegtm view main')->only('index');
        $this->druidClient = new DruidClient(['router_url' => env('DRUID_ROUTER_URL')]);
        $this->druidController = new DruidController($this->druidClient);
    }

    public function index()
    {
        return view('gtm.gtm');
    }

    public function getAccumOilProd():JsonResponse
    {
        $data = $this->druidController->getDruidData(
            'gtm_eff_forecast_v25',
            [
                [
                    'interval',
                    '2020-01-01T00:00:00+00:00',
                    '2020-12-31T23:59:59+00:00',
                ],
                [
                    'select',
                    '__time',
                    'dt',
                    function (ExtractionBuilder $extractionBuilder) {
                        $extractionBuilder->timeFormat('yyyy-MM');
                    }
                ],
                [
                    'floatSum',
                    'add_prod_12m'
                ],
                [
                    'floatSum',
                    'plan_add_prod_12m'
                ],
            ],
            Granularity::MONTH
        );
        $result = [];
        foreach ($data as $item) {
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $item["dt"] . "-01 00:00:00", new \DateTimeZone("UTC"));
            $date = trans('paegtm.' . $dateTime->format('M')) . ' ' . $dateTime->format('Y');
            $result[] = [
                'date' => $date,
                'accumOilProdFactData' => $item[self::ACCUM_OIL_PROD_FACT_DATA_FIELD] / 1000,
                'accumOilProdPlanData' => $item[self::ACCUM_OIL_PROD_PLAN_DATA_FIELD] / 1000,
            ];
        }
        return response()->json($result);
    }

    public function getComparisonIndicators():JsonResponse
    {
        $data = $this->druidController->getDruidData(
            'gtm_eff_forecast_v25',
            [
                [
                    'interval',
                    '2020-01-01T00:00:00+00:00',
                    '2020-12-31T23:59:59+00:00',
                ],
                [
                    'select',
                    '__time',
                    'dt',
                    function (ExtractionBuilder $extractionBuilder) {
                        $extractionBuilder->timeFormat('yyyy');
                    }
                ],
                ['select', 'gtm_kind'],
                ['distinctCount', 'well_uwi'],
                ['sum', 'work_time'],
                ['floatSum', 'add_prod_12m'],
                ['floatSum','plan_add_prod_12m'],
            ],
            Granularity::YEAR
        );
        $result = [];
        foreach ($data as $item) {
            $result[] = [
                'gtm_kind' => $item['gtm_kind'],
                'wellsCount' => $item['well_uwi'],
                'avgDebitPlan' => $item['plan_add_prod_12m'] / $item['work_time'],
                'avgDebitFact' => $item['add_prod_12m'] / $item['work_time'],
                'add_prod_12m' => $item['add_prod_12m'] / 1000,
                'plan_add_prod_12m' => $item['plan_add_prod_12m'] / 1000,
                'work_time' => $item['work_time'] / $item['well_uwi'] / 12,
            ];
        }
        return response()->json($result);
    }
}

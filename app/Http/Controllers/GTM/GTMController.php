<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DruidController;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Gtm;
use App\Models\BigData\Well;
use App\Models\Paegtm\DzoAegtm;
use App\Services\DruidService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GTMController extends Controller
{

    const ACCUM_OIL_PROD_FACT_DATA_FIELD = 'add_prod_12m';
    const ACCUM_OIL_PROD_PLAN_DATA_FIELD = 'plan_add_prod_12m';

    /**
     * @var DruidController
     */
    private $druidController;

    public function __construct()
    {
//        $this->middleware('can:paegtm view main')->only('index');
    }

    public function index()
    {
        return view('gtm.gtm');
    }

    public function getAccumOilProd(DruidService $druidService, Request $request):JsonResponse
    {
        $data = $druidService->getAccumOilProd($request->dateStart, $request->dateEnd);
        $result = [];
        $accumOilProdFactData = 0;
        $accumOilProdPlanData = 0;
        foreach ($data as $item) {
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $item["dt"] . "-01 00:00:00", new \DateTimeZone("UTC"));
            $date = trans('paegtm.' . $dateTime->format('M')) . ' ' . $dateTime->format('Y');
            $accumOilProdFactData += $item[self::ACCUM_OIL_PROD_FACT_DATA_FIELD] / 1000;
            $accumOilProdPlanData += $item[self::ACCUM_OIL_PROD_PLAN_DATA_FIELD] / 1000;
            $result[] = [
                'date' => $date,
                'accumOilProdFactData' => $accumOilProdFactData,
                'accumOilProdPlanData' => $accumOilProdPlanData,
            ];
        }
        return response()->json($result);
    }

    public function getComparisonIndicators(DruidService $druidService, Request $request):JsonResponse
    {
        $data = $druidService->getComparisonIndicators($request->dateStart, $request->dateEnd);
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

    public function getAllGtmByDzo(Request $request)
    {
//        $dateStart = Carbon::createFromTimeString('2019-01-01T00:00:00.000Z');
//        $dateEnd = Carbon::createFromTimeString('2020-12-31T23:59:59.000Z');

        $dateStart = $request->has('dateStart') && $request->filled('dateStart') ?
            $request->dateStart :
            '2020-01-01T00:00:00+00:00';

        $dateEnd = $request->has('dateEnd') && $request->filled('dateEnd') ?
              $request->dateEnd :
              '2020-12-31T23:59:59+00:00';

        $dateStart = Carbon::createFromTimeString($dateStart);
        $dateEnd = Carbon::createFromTimeString($dateEnd);

        $sql = 'with
            recursive
            org_hash as (
                select id, id as parent, 1 as level
                from dict.org
                union all
                select o.id, org_hash.parent, level + 1 as level
                from dict.org o
                         join org_hash on org_hash.id = o.parent
                    and o.dbeg <= now()
                    and o.dend > now()
            ),
            wells as (
                select wo.well as id
                from prod.well_org wo
                where wo.org in (select id from org_hash where parent = :org_id)
                  and wo.dbeg <= now()
                  and wo.dend > now()
            ),
            gtms as (
                select wells.id   as well_id,
                   gt.name_ru as gtm_type,
                   gk.name_ru as gtm_kind,
                   gtm.id     as gtm_id,
                   gtm.dbeg   as gtm_dbeg,
                   gtm.dend   as gtm_dend
                from wells
                     join prod.gtm gtm on gtm.well = wells.id
                         and gtm.dbeg <= :date_end
                        and gtm.dend > :date_start
                     join dict.gtm_type gt on gt.id = gtm.gtm_type
                     left join dict.gtm_kind gk on gk.id = gt.gtm_kind
                where gtm.well in (select id from wells)
            )
        select gtm_kind, 0 as plan, count(*) as fact, 0 as percent_1, 0 as percent_2
        from gtms
        group by gtm_kind
        order by 3 desc';

        $res = new Collection(DB::connection('tbd')->select(DB::raw($sql), ['org_id' => $request->dzoId, 'date_start' => $dateStart, 'date_end' => $dateEnd]));

        return response()->json($res);
    }

    public function getMainTableData(Request $request)
    {
//        $tableData = [
//           [ 'id' => 3,
//             'name_ru' => 'АО "Озенмунайгаз"',
//             'name_short_ru' => 'ОМГ',
//             'col_1' => 231,
//             'col_2' => 284,
//             'col_3' => 53,
//             'col_4' => 384,
//             'col_5' => 368,
//             'col_6' => -16,
//             'col_7' => 4724,
//             'col_8' => 4687,
//             'col_9' => -37,
//             'col_10' => 5341,
//             'col_11' => 5341,
//             'col_12' => 0,
//             'selected' => false
//           ],
//          [ 'id' => 4,
//            'name_ru' => 'АО "ЭмбаМунайГаз"',
//            'name_short_ru' => 'ЭМБА',
//            'col_1' => 61,
//            'col_2' => 74,
//            'col_3' => +13,
//            'col_4' => 87,
//            'col_5' => 120,
//            'col_6' => +33,
//            'col_7' => 2453,
//            'col_8' => 2407,
//            'col_9' => -46,
//            'col_10' => 2600,
//            'col_11' => 2601,
//            'col_12' => 0,
//            'selected' => false
//          ],
//          [ 'id' => 112,
//            'name_ru' => 'АО "Мангистаумунайгаз"',
//            'name_short_ru' => 'ММГ',
//            'col_1' => 348,
//            'col_2' => 274,
//            'col_3' => -74,
//            'col_4' => 283,
//            'col_5' => 184,
//            'col_6' => -100,
//            'col_7' => 5273,
//            'col_8' => 5496,
//            'col_9' => +223,
//            'col_10' => 5922,
//            'col_11' => 5954,
//            'col_12' => +32,
//            'selected' => false
//          ],
//          [ 'id' => 71,
//            'name_ru' => 'АО "Каражанбасмунай"',
//            'name_short_ru' => 'КРЖМ',
//            'col_1' => 50,
//            'col_2' => 46,
//            'col_3' => -3,
//            'col_4' => 26,
//            'col_5' => 24,
//            'col_6' => -2,
//            'col_7' => 2077,
//            'col_8' => 1930,
//            'col_9' => -147,
//            'col_10' => 2153,
//            'col_11' => 2002,
//            'col_12' => -150,
//            'selected' => false
//          ],
//          [ 'id' => 149,
//            'name_ru' => 'ТОО "СП "Казгермунай"',
//            'name_short_ru' => 'КАЗГЕР',
//            'col_1' => 15,
//            'col_2' => 10,
//            'col_3' => -5,
//            'col_4' => 58,
//            'col_5' => 45,
//            'col_6' => -13,
//            'col_7' => 1465,
//            'col_8' => 1482,
//            'col_9' => +17,
//            'col_10' => 1538,
//            'col_11' => 1555,
//            'col_12' => +17,
//            'selected' => false
//          ],
//          [ 'id' => 117,
//            'name_ru' => 'ТОО "Казтуркмунай"',
//            'name_short_ru' => 'КТМ',
//            'col_1' => 9,
//            'col_2' => 8,
//            'col_3' => -1,
//            'col_4' => 26,
//            'col_5' => 24,
//            'col_6' => -2,
//            'col_7' => 396,
//            'col_8' => 409,
//            'col_9' => +13,
//            'col_10' => 425,
//            'col_11' => 432,
//            'col_12' => +7,
//            'selected' => false
//          ],
//          [ 'id' => 126,
//            'name_ru' => 'ТОО "Казахойл Актобе"',
//            'name_short_ru' => 'КАЗА',
//            'col_1' => 0,
//            'col_2' => 0,
//            'col_3' => 0,
//            'col_4' => 3,
//            'col_5' => 1,
//            'col_6' => -2,
//            'col_7' => 586,
//            'col_8' => 588,
//            'col_9' => +2,
//            'col_10' => 588,
//            'col_11' => 589,
//            'col_12' => +1,
//            'selected' => false
//          ]
//        ];

//        if ($request->filled('dzoId')) {
//            foreach ($tableData as $key => $dzo) {
//                if ($dzo['id'] == $request->dzoId) {
//                    $tableData[$key]['selected'] = true;
//                }
//            }
//        }
        $query = DzoAegtm::query();

        $query->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });

        $query->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request) {
            return $q->whereBetween('date', [
                request('dateStart', '2021-01-01 00:00:00'),
                request('dateEnd', '2021-01-01 00:00:00'),
            ]);
        });

        $data = $query
            ->orderBy('date', 'ASC')
            ->get()
            ->groupBy('org_name');

        $result = [];

        foreach ($data as $key => $dzoItems) {

            $vnsAdditionalOilProdPlan = 0;
            $vnsAdditionalOilProdFact = 0;
            $gtmAdditionalOilProdPlan = 0;
            $gtmAdditionalOilProdFact = 0;
            $baseOilProdPlan = 0;
            $baseOilProdFact = 0;
            $oilProdPlan = 0;
            $oilProdFact = 0;

            foreach ($dzoItems as $item) {
                $vnsAdditionalOilProdPlan += $item->vns_prod_plan_total;
                $vnsAdditionalOilProdFact += $item->vns_prod_fact_total;

                $gtmAdditionalOilProdPlan += $item->gtm_oil_prod_plan;
                $gtmAdditionalOilProdFact += $item->gtm_oil_prod_fact;

                $baseOilProdPlan += $item->base_oil_prod_plan;
                $baseOilProdFact += $item->base_oil_prod_fact;

                $oilProdPlan += $item->oil_prod_plan;
                $oilProdFact += $item->oil_prod_fact;
            }

            $result[$key] = [
                'name_ru' => $key,
                'vns_additional_oil_prod_plan' => $vnsAdditionalOilProdPlan,
                'vns_additional_oil_prod_fact' => $vnsAdditionalOilProdFact,
                'vns_additional_oil_prod_difference' => $vnsAdditionalOilProdFact - $vnsAdditionalOilProdPlan,

                'gtm_additional_oil_prod_plan' => $gtmAdditionalOilProdPlan,
                'gtm_additional_oil_prod_fact' => $gtmAdditionalOilProdFact,
                'gtm_additional_oil_prod_difference' => $gtmAdditionalOilProdFact - $gtmAdditionalOilProdPlan,

                'base_oil_prod_plan' => $baseOilProdPlan,
                'base_oil_prod_fact' => $baseOilProdFact,
                'base_oil_prod_difference' => $baseOilProdFact - $baseOilProdPlan,

                'oil_prod_plan' => $oilProdPlan,
                'oil_prod_fact' => $oilProdFact,
                'oil_prod_difference' => $oilProdFact - $oilProdPlan,
            ];

        }

//        dd($result);

        return response()->json($result);
    }

    public function getMainIndicatorData(Request $request)
    {
        $dzoName = $request->filled('dzoName') ? $request->dzoName : 'ММГ';
        $dateStart = $request->filled('dateStart') ? $request->dateStart : '2021-01-01 00:00:00';
        $dateEnd = $request->filled('dateEnd') ? $request->dateEnd : '2021-01-01 00:00:00';

        $result = [];

        $data = DzoAegtm::where('org_name_short', $dzoName)
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->orderBy('date', 'ASC')
            ->get();

        $gtmAndVnsCountPlan = 0;
        $gtmAndVnsCountFact = 0;
        $vnsAdditionalOilProdPlan = 0;
        $vnsAdditionalOilProdFact = 0;
        $gtmAdditionalOilProdPlan = 0;
        $gtmAdditionalOilProdFact = 0;
        $baseOilProdPlan = 0;
        $baseOilProdFact = 0;

        foreach ($data as $item) {
            $gtmAndVnsCountPlan +=
                $item->vns_plan_total +
                $item->gs_plan +
                $item->zbs_plan +
                $item->zbgs_plan +
                $item->grp_plan +
                $item->pvlg_plan +
                $item->pvr_plan;

            $gtmAndVnsCountFact +=
                $item->vns_fact_total +
                $item->gs_fact +
                $item->zbs_fact +
                $item->zbgs_fact +
                $item->grp_fact +
                $item->pvlg_fact +
                $item->pvr_fact;

            $vnsAdditionalOilProdPlan += $item->vns_prod_plan_total;
            $vnsAdditionalOilProdFact += $item->vns_prod_fact_total;

            $gtmAdditionalOilProdPlan += $item->gtm_oil_prod_plan;
            $gtmAdditionalOilProdFact += $item->gtm_oil_prod_fact;

            $baseOilProdPlan += $item->base_oil_prod_plan;
            $baseOilProdFact += $item->base_oil_prod_fact;
        }

        $result[] = [
            'number' => $gtmAndVnsCountFact,
            'units' => trans('paegtm.activities'),
            'title' => trans('paegtm.number_of_gtm_and_vns'),
            'progressValue' => $gtmAndVnsCountFact,
            'progressMax' => $gtmAndVnsCountPlan,
            'progressPercents' => $gtmAndVnsCountFact / $gtmAndVnsCountPlan * 100,
        ];

        $result[] = [
            'number' => $vnsAdditionalOilProdFact,
            'units' => trans('paegtm.tons'),
            'title' => trans('paegtm.additional_oil_production_from_vns'),
            'progressValue' => $vnsAdditionalOilProdFact,
            'progressMax' => $vnsAdditionalOilProdPlan,
            'progressPercents' => $vnsAdditionalOilProdFact / $vnsAdditionalOilProdPlan * 100,
        ];

        $result[] = [
            'number' => $gtmAdditionalOilProdFact,
            'units' => trans('paegtm.tons'),
            'title' => trans('paegtm.additional_oil_production_from_gtm'),
            'progressValue' => $gtmAdditionalOilProdFact,
            'progressMax' => $gtmAdditionalOilProdPlan,
            'progressPercents' => $gtmAdditionalOilProdFact / $gtmAdditionalOilProdPlan * 100,
        ];

        $result[] = [
            'number' => $baseOilProdFact,
            'units' => trans('paegtm.tons'),
            'title' => trans('paegtm.basic_oil_production'),
            'progressValue' => $baseOilProdFact,
            'progressMax' => $baseOilProdPlan,
            'progressPercents' => $baseOilProdFact / $baseOilProdPlan * 100,
        ];

        return response()->json($result);
    }

    public function getAdditionalIndicatorData(Request $request)
    {
        $dzoName = $request->filled('dzoName') ? $request->dzoName : 'ММГ';
        $dateStart = $request->filled('dateStart') ? $request->dateStart : '2021-01-01 00:00:00';
        $dateEnd = $request->filled('dateEnd') ? $request->dateEnd : '2021-01-01 00:00:00';

        $result = [];

        $data = DzoAegtm::where('org_name_short', $dzoName)
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->orderBy('date', 'ASC')
            ->get();

        $oilProdPlan = 0;
        $oilProdFact = 0;

        foreach ($data as $item) {
            $oilProdPlan += $item->oil_prod_plan;
            $oilProdFact += $item->oil_prod_fact;
        }

        $result[] = [
            'number' => $oilProdFact,
            'units' => trans('paegtm.tons'),
            'title' => trans('paegtm.oil_production'),
            'progressValue' => $oilProdFact,
            'progressMax' => $oilProdPlan,
            'progressPercents' => $oilProdFact / $oilProdPlan * 100,
        ];

        return response()->json($result);
    }

    public function getGtmInfo(Request $request)
    {
        $query = DzoAegtm::query();

        $query->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });

        $query->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request){
            return $q->whereBetween('date', [
                $request->dateStart,
                $request->dateEnd,
            ]);
        });

        $data = $query
            ->orderBy('date', 'ASC')
            ->get();

        $result = [];

        $vnsPlan = $vnsFact = $vnsGrpPlan = $vnsGrpFact = $gsPlan
            = $gsFact = $zbsPlan = $zbsFact = $zbgsPlan = $zbgsFact
            = $grpPlan = $grpFact = $pvlgPlan = $pvlgFact = $pvrPlan = $pvrFact = 0;


        foreach ($data as $item) {
            $vnsPlan+= $item->vns_plan;
            $vnsFact+= $item->vns_fact;

            $vnsGrpPlan+= $item->vns_grp_plan;
            $vnsGrpFact+= $item->vns_grp_fact;

            $gsPlan+= $item->gs_plan;
            $gsFact+= $item->gs_fact;

            $zbsPlan+= $item->zbs_plan;
            $zbsFact+= $item->zbs_fact;

            $zbgsPlan+= $item->zbgs_plan;
            $zbgsFact+= $item->zbgs_fact;

            $grpPlan+= $item->grp_plan;
            $grpFact+= $item->grp_fact;

            $pvlgPlan+= $item->pvlg_plan;
            $pvlgFact+= $item->pvlg_fact;

            $pvrPlan+= $item->pvr_plan;
            $pvrFact+= $item->pvr_fact;
        }

        $result[] = [
            'ВНС',
            $vnsPlan,
            $vnsFact,
            0,
            0
        ];

        $result[] = [
            'ВНС ГРП',
            $vnsGrpPlan,
            $vnsGrpFact,
            0,
            0
        ];

        $result[] = [
            'ГС',
            $gsPlan,
            $gsFact,
            0,
            0
        ];

        $result[] = [
            'ЗБС',
            $zbsPlan,
            $zbsFact,
            0,
            0
        ];

        $result[] = [
            'ЗБГС',
            $zbgsPlan,
            $zbgsFact,
            0,
            0
        ];

        $result[] = [
            'ГРП',
            $grpPlan,
            $grpFact,
            0,
            0
        ];

        $result[] = [
            'ПВЛГ',
            $pvlgPlan,
            $pvlgFact,
            0,
            0
        ];

        $result[] = [
            'ПВР',
            $pvrPlan,
            $pvrFact,
            0,
            0
        ];

        return response()->json($result);
    }

    public function getChartData(Request $request)
    {
        $query = DzoAegtm::query();

        $query->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });

        $query->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request){
            return $q->whereBetween('date', [
                $request->dateStart,
                $request->dateEnd,
            ]);
        });

        $data = $query
            ->orderBy('date', 'ASC')
            ->get();

        $result = [];

        $vnsPlan = $vnsFact = $vnsProdPlan = $vnsProdFact =  [];
        $gtmPlan = $gtmFact = $gtmProdPlan = $gtmProdFact =  [];

        foreach ($data as $item) {
            $vnsPlan[] =  $item->vns_plan_chart;
            $vnsFact[] = $item->vns_fact_chart;
            $vnsProdPlan[] = round($item->vns_prod_plan_chart, 2);
            $vnsProdFact[] = round($item->vns_prod_fact_chart, 2);

            $gtmPlan[] =  $item->gtm_plan_chart;
            $gtmFact[] = $item->gtm_fact_chart;
            $gtmProdPlan[] = round($item->gtm_prod_plan_chart, 2);
            $gtmProdFact[] = round($item->gtm_prod_fact_chart, 2);
        }

        $result['series_1'][] = [
            'name' => trans('paegtm.planEd'),
            'type' => 'column',
            'data' => $vnsPlan
        ];

        $result['series_1'][] = [
            'name' => trans('paegtm.factEd'),
            'type' => 'column',
            'data' => $vnsFact
        ];

        $result['series_1'][] = [
            'name' => trans('paegtm.planOil'),
            'type' => 'line',
            'data' => $vnsProdPlan
        ];

        $result['series_1'][] = [
            'name' => trans('paegtm.factOil'),
            'type' => 'line',
            'data' => $vnsProdFact
        ];

        //

        $result['series_2'][] = [
            'name' => trans('paegtm.planEd'),
            'type' => 'column',
            'data' => $gtmPlan
        ];

        $result['series_2'][] = [
            'name' => trans('paegtm.factEd'),
            'type' => 'column',
            'data' => $gtmFact
        ];

        $result['series_2'][] = [
            'name' => trans('paegtm.planOil'),
            'type' => 'line',
            'data' => $gtmProdPlan
        ];

        $result['series_2'][] = [
            'name' => trans('paegtm.factOil'),
            'type' => 'line',
            'data' => $gtmProdFact
        ];

//        dd($result);

        return response()->json($result);
    }
}

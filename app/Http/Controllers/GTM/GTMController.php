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
use Illuminate\Database\Eloquent\Builder;
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
        $this->middleware('can:paegtm view main')->only('index');
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllGtmByDzo(Request $request)
    {
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

    /**
     * @param Request $request
     * @param bool $returnQuery
     * @return Builder[]|Collection
     */
    public function getMainData(Request $request, bool $returnQuery = false)
    {
        $query = DzoAegtm::query();

        $query->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });

        $query->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request) {
            return $q->whereBetween('date', [
                $request->input('dateStart', '2021-01-01 00:00:00'),
                $request->input('dateEnd', '2021-12-31 00:00:00'),
            ]);
        });

        return $returnQuery ?
            $query :
            $query->orderBy('date')->get();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMainTableData(Request $request): JsonResponse
    {
        $data = $this->getMainData($request)->groupBy('org_name');

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
            $orgNameShort = '';

            foreach ($dzoItems as $item) {
                $vnsAdditionalOilProdPlan += $item->vns_prod_plan_total;
                $vnsAdditionalOilProdFact += $item->vns_prod_fact_total;

                $gtmAdditionalOilProdPlan += $item->gtm_oil_prod_plan;
                $gtmAdditionalOilProdFact += $item->gtm_oil_prod_fact;

                $baseOilProdPlan += $item->base_oil_prod_plan;
                $baseOilProdFact += $item->base_oil_prod_fact;

                $oilProdPlan += $item->oil_prod_plan;
                $oilProdFact += $item->oil_prod_fact;

                $orgNameShort = $item->org_name_short;
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

                'org_name_short' => $orgNameShort,
                'selected' => $request->selectedDdzoName == $orgNameShort ? true : false,
            ];

        }

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMainIndicatorData(Request $request): JsonResponse
    {
        $data = $this->getMainData($request);

        $result = [];

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
                $item->pvr_plan +
                $item->gs_grp_plan +
                $item->deepening_plan +
                $item->grp_skin_plan +
                $item->perestrel_plan +
                $item->dostrel_plan +
                $item->vbd_plan +
                $item->opl_plan +
                $item->transfer_to_oil_plan +
                $item->uecn_plan +
                $item->pvlg_pri_prs_plan +
                $item->vpp_plan +
                $item->pfp_plan +
                $item->tgrp_plan +
                $item->vns_oper_plan +
                $item->vns_nn_plan +
                $item->vns_nn_oper_plan +
                $item->idn_plan;

            $gtmAndVnsCountFact +=
                $item->vns_fact_total +
                $item->gs_fact +
                $item->zbs_fact +
                $item->zbgs_fact +
                $item->grp_fact +
                $item->pvlg_fact +
                $item->pvr_fact +
                $item->gs_grp_fact +
                $item->deepening_fact +
                $item->grp_skin_fact +
                $item->perestrel_fact +
                $item->dostrel_fact +
                $item->vbd_fact +
                $item->opl_fact +
                $item->transfer_to_oil_fact +
                $item->uecn_fact +
                $item->pvlg_pri_prs_fact +
                $item->vpp_fact +
                $item->pfp_fact +
                $item->tgrp_fact +
                $item->vns_oper_fact +
                $item->vns_nn_fact +
                $item->vns_nn_oper_fact +
                $item->idn_fact;


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
            'progressPercents' => $gtmAndVnsCountPlan ? $gtmAndVnsCountFact / $gtmAndVnsCountPlan * 100 : 0,
        ];

        $result[] = [
            'number' => $vnsAdditionalOilProdFact,
            'units' => trans('paegtm.tons'),
            'title' => trans('paegtm.additional_oil_production_from_vns'),
            'progressValue' => $vnsAdditionalOilProdFact,
            'progressMax' => $vnsAdditionalOilProdPlan,
            'progressPercents' => $vnsAdditionalOilProdPlan ? $vnsAdditionalOilProdFact / $vnsAdditionalOilProdPlan * 100 : 0,
        ];

        $result[] = [
            'number' => $gtmAdditionalOilProdFact,
            'units' => trans('paegtm.tons'),
            'title' => trans('paegtm.additional_oil_production_from_gtm'),
            'progressValue' => $gtmAdditionalOilProdFact,
            'progressMax' => $gtmAdditionalOilProdPlan,
            'progressPercents' => $gtmAdditionalOilProdPlan ? $gtmAdditionalOilProdFact / $gtmAdditionalOilProdPlan * 100 : 0,
        ];

        $result[] = [
            'number' => $baseOilProdFact,
            'units' => trans('paegtm.tons'),
            'title' => trans('paegtm.basic_oil_production'),
            'progressValue' => $baseOilProdFact,
            'progressMax' => $baseOilProdPlan,
            'progressPercents' => $baseOilProdPlan ? $baseOilProdFact / $baseOilProdPlan * 100 : 0,
        ];

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAdditionalIndicatorData(Request $request): JsonResponse
    {
        $data = $this->getMainData($request);

        $result = [];

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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getGtmInfo(Request $request): JsonResponse
    {
        $data = $this->getMainData($request);

        $result = [];

        $vnsPlan = $vnsFact = $vnsGrpPlan = $vnsGrpFact = $gsPlan
            = $gsFact = $zbsPlan = $zbsFact = $zbgsPlan = $zbgsFact
            = $grpPlan = $grpFact = $pvlgPlan = $pvlgFact = $pvrPlan
            = $gsGrpPlan = $gsGrpFact = $deepeningPlan = $deepeningFact
            = $grpSkinPlan = $grpSkinFact = $perestrelPlan = $perestrelFact
            = $dostrelPlan = $dostrelFact = $vbdPlan = $vbdFact
            = $oplPlan = $oplFact = $transferToOilPlan = $transferToOilFact
            = $uecnPlan = $uecnFact = $pvlgPriPrsPlan = $pvlgPriPrsFact
            = $vppPlan = $vppFact = $pfpPlan = $pfpFact
            = $tgrpPlan = $tgrpFact = $vnsOperPlan = $vnsOperFact
            = $vnsNnPlan = $vnsNnFact = $vnsNnOperPlan = $vnsNnOperFact
            = $idnPlan = $idnFact
            = $pvrFact = 0;


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

            $gsGrpPlan+= $item->gs_grp_plan;
            $gsGrpFact+= $item->gs_grp_fact;

            $deepeningPlan+= $item->deepening_plan;
            $deepeningFact+= $item->deepening_fact;

            $grpSkinPlan+= $item->grp_skin_plan;
            $grpSkinFact+= $item->grp_skin_fact;

            $perestrelPlan+= $item->perestrel_plan;
            $perestrelFact+= $item->perestrel_fact;

            $dostrelPlan+= $item->dostrel_plan;
            $dostrelFact+= $item->dostrel_fact;

            $vbdPlan+= $item->vbd_plan;
            $vbdFact+= $item->vbd_fact;

            $oplPlan+= $item->opl_plan;
            $oplFact+= $item->opl_fact;

            $transferToOilPlan+= $item->transfer_to_oil_plan;
            $transferToOilFact+= $item->transfer_to_oil_fact;

            $uecnPlan+= $item->uecn_plan;
            $uecnFact+= $item->uecn_fact;

            $pvlgPriPrsPlan+= $item->pvlg_pri_prs_plan;
            $pvlgPriPrsFact+= $item->pvlg_pri_prs_fact;

            $vppPlan+= $item->vpp_plan;
            $vppFact+= $item->vpp_fact;

            $pfpPlan+= $item->pfp_plan;
            $pfpFact+= $item->pfp_fact;

            $tgrpPlan+= $item->tgrp_plan;
            $tgrpFact+= $item->tgrp_fact;

            $vnsOperPlan+= $item->vns_oper_plan;
            $vnsOperFact+= $item->vns_oper_fact;

            $vnsNnPlan+= $item->vns_nn_plan;
            $vnsNnFact+= $item->vns_nn_fact;

            $vnsNnOperPlan+= $item->vns_nn_oper_plan;
            $vnsNnOperFact+= $item->vns_nn_oper_fact;

            $idnPlan+= $item->idn_plan;
            $idnFact+= $item->idn_fact;
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

        $result[] = [
            'ГС+ГРП',
            $gsGrpPlan,
            $gsGrpFact,
            0,
            0
        ];

        $result[] = [
            'Углубление',
            $deepeningPlan,
            $deepeningFact,
            0,
            0
        ];

        $result[] = [
            'Скин ГРП',
            $grpSkinPlan,
            $grpSkinFact,
            0,
            0
        ];

        $result[] = [
            'Перестрел',
            $perestrelPlan,
            $perestrelFact,
            0,
            0
        ];

        $result[] = [
            'Дострел',
            $dostrelPlan,
            $dostrelFact,
            0,
            0
        ];

        $result[] = [
            'ВБД',
            $vbdPlan,
            $vbdFact,
            0,
            0
        ];

        $result[] = [
            'ОПЛ',
            $oplPlan,
            $oplFact,
            0,
            0
        ];

        $result[] = [
            'Перевод под нефть',
            $transferToOilPlan,
            $transferToOilFact,
            0,
            0
        ];

        $result[] = [
            'УЭЦН',
            $uecnPlan,
            $uecnFact,
            0,
            0
        ];

        $result[] = [
            'ПВЛГ при ПРС',
            $pvlgPriPrsPlan,
            $pvlgPriPrsFact,
            0,
            0
        ];

        $result[] = [
            'ВПП',
            $vppPlan,
            $vppFact,
            0,
            0
        ];

        $result[] = [
            'ПФП',
            $pfpPlan,
            $pfpFact,
            0,
            0
        ];

        $result[] = [
            'ТГРП',
            $tgrpPlan,
            $tgrpFact,
            0,
            0
        ];

        $result[] = [
            'ВНС опер.',
            $vnsOperPlan,
            $vnsOperFact,
            0,
            0
        ];

        $result[] = [
            'ВНС НН',
            $vnsNnPlan,
            $vnsNnFact,
            0,
            0
        ];

        $result[] = [
            'ВНС НН опер.',
            $vnsNnOperPlan,
            $vnsNnOperFact,
            0,
            0
        ];

        $result[] = [
            'ИДН',
            $idnPlan,
            $idnFact,
            0,
            0
        ];

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getChartData(Request $request): JsonResponse
    {
        $data = $this->getMainData($request, true)
            ->select(
                'date',
                DB::raw('
                    sum(vns_plan_chart) as vns_plan_chart,
                    sum(vns_fact_chart) as vns_fact_chart,
                    sum(vns_prod_plan_chart) as vns_prod_plan_chart,
                    sum(vns_prod_fact_chart) as vns_prod_fact_chart,
                    sum(gtm_plan_chart) as gtm_plan_chart,
                    sum(gtm_fact_chart) as gtm_fact_chart,
                    sum(gtm_prod_plan_chart) as gtm_prod_plan_chart,
                    sum(gtm_prod_fact_chart) as gtm_prod_fact_chart
                '))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $result = [];

        $vnsPlan = $vnsFact = $vnsProdPlan = $vnsProdFact =  [];
        $gtmPlan = $gtmFact = $gtmProdPlan = $gtmProdFact =  [];

        foreach ($data as $item) {
            $vnsPlan[] =  $item->vns_plan_chart;
            $vnsFact[] = $item->vns_fact_chart;
            $vnsProdPlan[] = round($item->vns_prod_plan_chart, 2);
            $vnsProdFact[] = round($item->vns_prod_fact_chart, 2);

            $gtmPlan[] =    round($item->gtm_plan_chart, 2);
            $gtmFact[] =    round($item->gtm_fact_chart, 2);
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

        return response()->json($result);
    }
}

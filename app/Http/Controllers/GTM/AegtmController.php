<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;
use App\Models\Paegtm\DzoAegtm;
use App\Models\Paegtm\TechEfficiency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AegtmController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:paegtm view main');
    }


    public function getComparisonTableData(Request $request): JsonResponse
    {
        $result = [];

        $techEfficiencyData = $this->getTechEfficiencyData($request);
        $dzoOtmData = $this->getDzoOtmData($request);

        $techEfficiencyResultGrouped = $techEfficiencyData->groupBy('gtm')->toArray();
        $techEfficiencyResult = $techEfficiencyData->groupBy('gtm')->map->count();

        $pvrPlan = $grpPlan = $vpsPlan = $pvlgPlan = $vnsPlan = $vnsGrpPlan = $vbdPlan = $zbgsPlan = $zbsPlan = $gsPlan = $gsGrpPlan = 0;
        $pvrProdPlan = $grpProdPlan = $vpsProdPlan = $pvlgProdPlan = $vnsProdPlan = $vnsGrpProdPlan = $vbdProdPlan = $zbgsProdPlan = $zbsProdPlan = $gsProdPlan = $gsGrpProdPlan = 0;

        foreach ($dzoOtmData as $item) {
            $pvrPlan+= $item->pvr_plan;
            $grpPlan+= $item->grp_plan;
            $vpsPlan+= $item->vps_plan;
            $pvlgPlan+= $item->pvlg_plan;
            $vnsPlan+= $item->vns_plan;
            $vnsGrpPlan+= $item->vns_grp_plan;
            $vbdPlan+= $item->vbd_plan;
            $zbgsPlan+= $item->zbgs_plan;
            $zbsPlan+= $item->zbs_plan;
            $gsPlan+= $item->gs_plan;
            $gsGrpPlan+= $item->gs_grp_plan;

            $pvrProdPlan+= $item->pvr_prod_plan;
            $grpProdPlan+= $item->grp_prod_plan;
            $pvlgProdPlan+= $item->pvlg_prod_plan;
            $vnsProdPlan+= $item->vns_prod_plan;
            $vnsGrpProdPlan+= $item->vns_grp_prod_plan;
            $vbdProdPlan+= $item->vbd_prod_plan;
            $zbgsProdPlan+= $item->zbgs_prod_plan;
            $zbsProdPlan+= $item->zbs_prod_plan;
            $gsProdPlan+= $item->gs_prod_plan;
            $gsGrpProdPlan+= $item->gs_grp_prod_plan;
        }

        if ($techEfficiencyResult) {
            foreach ($techEfficiencyResult as $gtm => $gtmCountFact) {
                $gtmProdFact = $gtmAvgIncreaseFact = 0;

                if(isset($techEfficiencyResultGrouped[$gtm])) {
                    $gtmProdFact = array_sum(array_column($techEfficiencyResultGrouped[$gtm],'sum_actual_production_month'));
                    $gtmAvgIncreaseFact = array_sum(array_column($techEfficiencyResultGrouped[$gtm],'avg_actual_increase_month'));
                }

                $gtmInfo['gtm'] = $gtm;
                $gtmInfo['count_fact'] = $gtmCountFact;
                $gtmInfo['add_prod_fact'] = $gtmProdFact ? round($gtmProdFact / 1000, 1) : 0;
                $gtmInfo['avg_increase_fact'] = $gtmAvgIncreaseFact && count($techEfficiencyResultGrouped[$gtm]) ? round($gtmAvgIncreaseFact / count($techEfficiencyResultGrouped[$gtm]), 1) : 0;

                $result[] = $gtmInfo;
            }

            foreach ($result as $key => $gtmItem) {
                switch ($gtmItem['gtm']) {
                    case 'ПВР':
                        $result[$key]['count_plan'] = $pvrPlan;
                        $result[$key]['add_prod_plan'] = round($pvrProdPlan, 1);
                        break;
                    case 'ГРП':
                        $result[$key]['count_plan'] = $grpPlan;
                        $result[$key]['add_prod_plan'] = round($grpProdPlan, 1);
                        break;
                    case 'ВПС':
                        $result[$key]['count_plan'] = $vpsPlan;
                        $result[$key]['add_prod_plan'] = round($vpsProdPlan, 1);
                        break;
                    case 'ПВЛГ':
                        $result[$key]['count_plan'] = $pvlgPlan;
                        $result[$key]['add_prod_plan'] = round($pvlgProdPlan, 1);
                        break;
                    case 'ВНС':
                        $result[$key]['count_plan'] = $vnsPlan;
                        $result[$key]['add_prod_plan'] = round($vnsProdPlan, 1);
                        break;
                    case 'ВНС_ГРП':
                        $result[$key]['count_plan'] = $vnsGrpPlan;
                        $result[$key]['add_prod_plan'] = round($vnsGrpProdPlan, 1);
                        break;
                    case 'ВБД':
                        $result[$key]['count_plan'] = $vbdPlan;
                        $result[$key]['add_prod_plan'] = round($vbdProdPlan, 1);
                        break;
                    case 'ЗБГС':
                        $result[$key]['count_plan'] = $zbgsPlan;
                        $result[$key]['add_prod_plan'] = round($zbgsProdPlan, 1);
                        break;
                    case 'ЗБС,ЗБГС':
                        $result[$key]['count_plan'] = $zbsPlan;
                        $result[$key]['add_prod_plan'] = round($zbsProdPlan, 1);
                        break;
                    case 'ГС':
                        $result[$key]['count_plan'] = $gsPlan;
                        $result[$key]['add_prod_plan'] = round($gsProdPlan, 1);
                        break;
                    case 'ГС_ГРП':
                        $result[$key]['count_plan'] = $gsGrpPlan;
                        $result[$key]['add_prod_plan'] = round($gsGrpProdPlan, 1);
                        break;
                }
            }
        }

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function getTechEfficiencyData(Request $request): Collection
    {
        $techEfficiencyQuery = TechEfficiency::query();

        $techEfficiencyQuery->select(
            'gtm',
            'uwi',
            DB::raw('sum(actual_production_month) as sum_actual_production_month'),
            DB::raw('avg(cast(NULLIF(actual_increase_month, 0) AS DOUBLE PRECISION)) AS avg_actual_increase_month')
        );

        $techEfficiencyQuery->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });


        $techEfficiencyQuery->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request) {
            return $q->whereBetween('month', [
                $request->input('dateStart'),
                $request->input('dateEnd'),
            ])
                ->whereBetween('date_start_after_gtm', [
                    $request->input('dateStart'),
                    $request->input('dateEnd'),
                ]);
        });

        return $techEfficiencyQuery->groupBy('gtm', 'uwi')->get();
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function getDzoOtmData(Request $request): Collection
    {
        $dzoAegtmQuery = DzoAegtm::query();

        $dzoAegtmQuery->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });

        $dzoAegtmQuery->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request) {
            return $q->whereBetween('date', [
                $request->input('dateStart'),
                $request->input('dateEnd'),
            ]);
        });

        return $dzoAegtmQuery->orderBy('date')->get();
    }
}

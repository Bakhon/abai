<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;
use App\Models\Paegtm\DzoAegtm;
use App\Models\Paegtm\TechEfficiency;
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

        //TODO: вынести в отдельный метод
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

        $techEfficiencyResult = $techEfficiencyQuery->groupBy('gtm', 'uwi')->get();

        $techEfficiencyResultGrouped = $techEfficiencyResult->groupBy('gtm')->toArray();

        $techEfficiencyResult = $techEfficiencyResult->groupBy('gtm')->map->count();



        //TODO: вынести в отдельный метод
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

        $dzoAegtmResult = $dzoAegtmQuery->orderBy('date')->get();

        $pvrPlan = $grpPlan = $vpsPlan = $pvlgPlan = 0;
        $pvrProdPlan = $grpProdPlan = $vpsProdPlan = $pvlgProdPlan = 0;

        foreach ($dzoAegtmResult as $item) {
            $pvrPlan+= $item->pvr_plan;
            $grpPlan+= $item->grp_plan;
            $vpsPlan+= $item->vps_plan;
            $pvlgPlan+= $item->pvlg_plan;

            $pvrProdPlan+= $item->pvr_prod_plan;
            $grpProdPlan+= $item->grp_prod_plan;
            $pvlgProdPlan+= $item->pvlg_prod_plan;
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
                }
            }
        }

        return response()->json($result);
    }
}

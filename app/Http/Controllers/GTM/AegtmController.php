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
        //TODO: вынести в отдельный метод
        $techEfficiencyQuery = TechEfficiency::query();

        $techEfficiencyQuery->select('gtm', 'uwi');

        $techEfficiencyQuery->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });

        $techEfficiencyQuery->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request) {
            return $q->whereBetween('month', [
                $request->input('dateStart'),
                $request->input('dateEnd'),
            ]);
        });

        $techEfficiencyResult = $techEfficiencyQuery->groupBy('gtm', 'uwi')->get();

        if(!$techEfficiencyResult) {
            return response()->json([]);
        }

        $techEfficiencyResult = $techEfficiencyResult->groupBy('gtm')->map->count();
//        dd($techEfficiencyResult);


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

        foreach ($dzoAegtmResult as $item) {
            $pvrPlan+= $item->pvr_plan;
            $grpPlan+= $item->grp_plan;
            $vpsPlan+= $item->vps_plan;
            $pvlgPlan+= $item->pvlg_plan;
        }

        return response()->json([]);
    }
}

<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;
use App\Models\Paegtm\GtmFactorAnalysis;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GtmFactorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:paegtm view main');
    }

    /**
     * @param Request $request
     * @param bool $returnQuery
     * @return JsonResponse
     */
    public function getGtmFactorsData(Request $request): JsonResponse
    {
        $dzoGtmFactorsQuery = GtmFactorAnalysis::query();

        $dzoGtmFactorsQuery->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });

        $dzoGtmFactorsQuery->when($request->filled('selectedGtm'), function ($q) use ($request) {
            return $q->whereIn('gtm', $request->selectedGtm);
        });

        $dzoGtmFactorsQuery->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request) {
            return $q->whereBetween('gtm_date', [
                $request->input('dateStart'),
                $request->input('dateEnd'),
            ]);
        });

        $result = $dzoGtmFactorsQuery->orderBy('gtm_date', 'desc')->get();

        $result = $result->map(function($item) {
            $item->q_l_before_gtm = round($item->q_l_before_gtm, 1);
            $item->q_o_before_gtm = round($item->q_o_before_gtm, 1);
            $item->wct_before_gtm = round($item->wct_before_gtm, 1);

            $item->gtm_date = $item->gtm_date ? Carbon::parse($item->gtm_date)->format('d.m.Y') : '';

            $item->q_l_plan = round($item->q_l_plan, 1);
            $item->q_o_plan = round($item->q_o_plan, 1);
            $item->wct_plan = round($item->wct_plan, 1);

            $item->q_l_after_gtm = round($item->q_l_after_gtm, 1);
            $item->q_o_after_gtm = round($item->q_o_after_gtm, 1);
            $item->wct_after_gtm = round($item->wct_after_gtm, 1);

            $item->q_l_deviation = round($item->q_l_deviation, 1);
            $item->q_o_deviation = round($item->q_o_deviation, 1);

            return $item;
        });

        return response()->json($result);
    }
}

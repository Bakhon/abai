<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;
use App\Models\Paegtm\GtmFactorAnalysis;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GtmFactorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:paegtm view main');
    }

    /**
     * @param Request $request
     * @param bool $returnQuery
     * @return Builder[]|Collection
     */
    public function getMainData(Request $request, bool $returnQuery = false)
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

        return $returnQuery ?
            $dzoGtmFactorsQuery :
            $dzoGtmFactorsQuery->orderBy('gtm_date', 'desc')->get();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getGtmFactorsData(Request $request): JsonResponse
    {
        $data = $this->getMainData($request);

        $result = $data->map(function($item) {
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

    public function getFactorsChartData(Request $request): JsonResponse
    {
        $result = [];
        $unsuccessfulDistributionLabels = $liqLabels = $wctLabels = [];
        $unsuccessfulDistributionChartData = $liqData = $wctData = [];

        $data = $this->getMainData($request);

        $unsuccessfulDistributionGtmData = $data->groupBy('failure_factor')->map->count();
        $liqFailureData = $data->where('failure_factor', __('paegtm.liquid'))->groupBy('failure_reason')->map->count();
        $wctFailureData = $data->where('failure_factor', __('paegtm.watercut'))->groupBy('failure_reason')->map->count();

        if ($unsuccessfulDistributionGtmData) {
            foreach ($unsuccessfulDistributionGtmData as $factorName => $factorsCount) {
                $unsuccessfulDistributionLabels[] =  $factorName;
                $unsuccessfulDistributionChartData[] = $factorsCount;
            }
        }

        if ($liqFailureData) {
            foreach ($liqFailureData as $reason => $count) {
                $liqLabels[] =  $reason;
                $liqData[] = $count;
            }
        }

        if ($wctFailureData) {
            foreach ($wctFailureData as $reason => $count) {
                $wctLabels[] =  $reason;
                $wctData[] = $count;
            }
        }

        $result['unsuccessful_distribution_gtm_data'] = [
            'labels' => $unsuccessfulDistributionLabels,
            'data' => $unsuccessfulDistributionChartData
        ];

        $result['liq_data'] = [
            'labels' => $liqLabels,
            'data' => $liqData
        ];

        $result['wct_data'] = [
            'labels' => $wctLabels,
            'data' => $wctData
        ];

        return response()->json($result);
    }
}

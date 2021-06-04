<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\LostProfitsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\LostProfitsListResource;
use App\Models\ComplicationMonitoring\LostProfits;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Support\Facades\Session;

class LostProfitsController extends Controller
{protected $modelName = 'omguhe';

    public function index(): \Illuminate\View\View
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('lost_profits.list'),
            ],
            'title' => trans('monitoring.lost_profits_title'),
            'table_header' => [
                trans('monitoring.lost_profits_title') => 9,
            ],
            'fields' => [
                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('lost_profits')
                            ->orderBy('name', 'asc')
                            ->get()
                            ->map(
                                function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'name' => $item->name,
                                    ];
                                }
                            )
                            ->toArray()
                    ]
                ],
                'date' => [
                    'title' => trans('app.date'),
                    'type' => 'date',
                ],
                'сorrosion' => [
                    'title' => trans('monitoring.calc_common_corrosion_speed'),
                    'type' => 'numeric',
                ],
                'actual_inhibitor_injection' => [
                    'title' => trans('monitoring.actual_inhibitor_level'),
                    'type' => 'numeric',
                ],
                'recommended_inhibitor_injection' => [
                    'title' => trans('monitoring.ik_recommend'),
                    'type' => 'numeric',
                ],
                'difference' => [
                    'title' => trans('monitoring.difference'),
                    'type' => 'numeric',
                ],
                'inhibitor_price' => [
                    'title' => trans('monitoring.inhibitor_price'),
                    'type' => 'numeric',
                ],
                'lost_profits' => [
                    'title' => trans('monitoring.lost_profits'),
                    'type' => 'numeric',
                ],
                'lost_profits_sum' => [
                    'title' => trans('monitoring.lost_profits_sum'),
                    'type' => 'numeric',
                ],
            ]
        ];

        return view('complicationMonitoring.lost_profits.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = LostProfits::query()
            ->with('gu');

        $ecomonical_effect = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(LostProfitsListResource::collection($ecomonical_effect)->toJson()));
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new LostProfitsFilter($query, $filter))->filter();
    }
}

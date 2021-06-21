<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\EconomicalEffectFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\EconomicalEffectListResource;
use App\Models\ComplicationMonitoring\EconomicalEffect;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Support\Facades\Session;

class EconomicalEffectController extends CrudController
{    
    protected $modelName = 'economical_effect';

    public function index(): \Illuminate\View\View
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('economical_effect.list'),
            ],
            'title' => trans('monitoring.economical_effect_title'),
            'table_header' => [
                trans('monitoring.economical_effect_title') => 9,
            ],
            'fields' => [
                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('economical_effect')
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
                'economical_effect' => [
                    'title' => trans('monitoring.economical_effect'),
                    'type' => 'numeric',
                ],
                'economical_effect_sum' => [
                    'title' => trans('monitoring.economical_effect_sum'),
                    'type' => 'numeric',
                ],
            ]
        ];

        $params['model_name'] = $this->modelName;
        $params['filter'] = session($this->modelName.'_filter');

        return view('complicationMonitoring.economical_effect.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        parent::list($request);

        $query = EconomicalEffect::query()
            ->with('gu');

        $ecomonical_effect = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(EconomicalEffectListResource::collection($ecomonical_effect)->toJson()));
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new EconomicalEffectFilter($query, $filter))->filter();
    }
}

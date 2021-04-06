<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Requests\IndexTableRequest;
use App\Models\ComplicationMonitoring\PipeType;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Session;

class PipeTypesController extends CrudController
{
    protected $modelName = 'pipe_types';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('pipe_types.list'),
            ],
            'title' => trans('monitoring.pipe_types.title'),
            'fields' => [
                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('pipe')
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
                'name' => [
                    'title' => trans('monitoring.pipe_types.fields.name'),
                    'type' => 'numeric',
                ],
                'outside_diameter' => [
                    'title' => trans('monitoring.pipe_types.fields.outside_diameter'),
                    'type' => 'numeric',
                ],
                'inner_diameter' => [
                    'title' => trans('monitoring.pipe_types.fields.inner_diameter'),
                    'type' => 'numeric',
                ],
                'thickness' => [
                    'title' => trans('monitoring.pipe_types.fields.thickness'),
                    'type' => 'numeric',
                ],
                'roughness' => [
                    'title' => trans('monitoring.pipe_types.fields.roughness'),
                    'type' => 'numeric',
                ],
                'material' => [
                    'title' => trans('monitoring.pipe_types.fields.material'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\ComplicationMonitoring\Material::whereHas('pipeType')
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
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('pipe_types.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = PipeType::all();

        $pipe_type = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\PipeListResource::collection($pipe_type)->toJson()));
    }
}

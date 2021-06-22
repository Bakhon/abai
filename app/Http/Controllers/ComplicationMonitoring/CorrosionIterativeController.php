<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\CorrosionIterativeFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\CorrosionIterativeCreateRequest;
use App\Http\Requests\CorrosionIterativeUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Models\ComplicationMonitoring\Corrosioniterative;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\CorrosionIterativeListResource;

class CorrosionIterativeController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'corrosion';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('corrosioncrud.list'),
            ],
            'title' => trans('monitoring.corrosion_iterative.title'),
            'fields' => [
                
                
                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('corrosion')
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
                
                'background_corrosion_velocity' => [
                    'title' => trans('monitoring.corrosion.fields.background_corrosion_velocity'),
                    'type' => 'numeric',
                ],
                'date_for_corrosion' => [
                    'title' => trans('monitoring.gu.fields.date'),
                    'type' => 'date',
                ],
                'carbon_dioxide' => [
                    'title' => trans('monitoring.wm.fields.carbon_dioxide'),
                    'type' => 'numeric',
                ],
                'date_for_carbon_dioxide' => [
                    'title' => trans('monitoring.gu.fields.date'),
                    'type' => 'numeric',
                ],
                'volume_fractions_for_carbon_dioxide' => [
                    'title' => trans('monitoring.corrosion.volume_fractions	'),
                    'type' => 'numeric',
                ],
                'surge_tank_pressure' => [
                    'title' => trans('monitoring.corrosion.fields.days'),
                    'type' => 'numeric',
                ],
                'carbon_dioxide_pressure' => [
                    'title' => trans('monitoring.corrosion.fields.weight_after'),
                    'type' => 'numeric',
                ],
                'hydrogen_sulfide_in_gas' => [
                    'title' => trans('monitoring.corrosion.fields.avg_speed'),
                    'type' => 'numeric',
                ],
                'date_for_hydrogen_sulfide' => [
                    'title' => trans('monitoring.gu.fields.date'),
                    'type' => 'numeric',
                ],
                'volume_fractions_for_hydrogen_sulfide' => [
                    'title' => trans('monitoring.corrosion.volume_fractions'),
                    'type' => 'numeric',
                ],
                'hydrogen_sulfide_in_gas_pressure' => [
                    'title' => trans('monitoring.corrosion.fields.weight_after'),
                    'type' => 'numeric',
                ],
                'calculated_corrosion_speed' => [
                    'title' => trans('monitoring.corrosion.fields.weight_after'),
                    'type' => 'numeric',
                ]
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route('corrosioncrud.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route('corrosioncrud.export');
        }

        return view('complicationMonitoring.corrosion.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = CorrosionIterative::query()
            ->with('field')
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu');

        $corrosion = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(CorrosionIterativeListResource::collection($corrosion)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new \App\Jobs\ExportCorrosionToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validationParams = $this->getValidationParams('corrosioncrud');
        return view('complicationMonitoring.corrosion.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorrosionIterativeCreateRequest $request)
    {
        $this->validateFields($request, 'corrosioncrud');

        CorrosionIterative::create($request->validated());
        return redirect()->route('corrosioncrud.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Corrosioniterative $corrosioncrud)
    {
        return view('complicationMonitoring.corrosion.show', ['corrosion' => $corrosioncrud]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(Corrosioniterative $corrosion)
    {
        $corrosion->load('history');
        return view('complicationMonitoring.corrosion.history', compact('corrosion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Corrosioniterative $corrosioncrud)
    {
        $validationParams = $this->getValidationParams('corrosioncrud');
        return view('complicationMonitoring.corrosion.edit', [
            'corrosion' => $corrosioncrud,
            'validationParams' => $validationParams
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CorrosionIterativeUpdateRequest $request, Corrosioniterative $corrosioncrud)
    {
        $this->validateFields($request, 'corrosioncrud');

        $corrosioncrud->update($request->validated());
        return redirect()->route('corrosioncrud.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Corrosioniterative $corrosioncrud)
    {
        $corrosioncrud->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('corrosioncrud.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new CorrosionIterativeFilter($query, $filter))->filter();
    }
}

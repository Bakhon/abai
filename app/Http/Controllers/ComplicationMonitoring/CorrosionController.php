<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\CorrosionFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\CorrosionCreateRequest;
use App\Http\Requests\CorrosionUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Models\ComplicationMonitoring\Corrosion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class CorrosionController extends CrudController
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
            'title' => trans('monitoring.corrosion.title'),
            'fields' => [
                
                
                'gu' => [
                    'title' => trans('monitoring.gu'),
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
                'start_date_of_background_corrosion' => [
                    'title' => trans('monitoring.corrosion.fields.start_date_of_background_corrosion'),
                    'type' => 'date',
                ],
                'final_date_of_background_corrosion' => [
                    'title' => trans('monitoring.corrosion.fields.final_date_of_background_corrosion'),
                    'type' => 'date',
                ],
                'background_corrosion_velocity' => [
                    'title' => trans('monitoring.corrosion.fields.background_corrosion_velocity'),
                    'type' => 'numeric',
                ],
                'start_date_of_corrosion_velocity_with_inhibitor_measure' => [
                    'title' => trans('monitoring.corrosion.fields.start_date_of_corrosion_velocity_with_inhibitor_measure'),
                    'type' => 'date',
                ],
                'final_date_of_corrosion_velocity_with_inhibitor_measure' => [
                    'title' => trans('monitoring.corrosion.fields.final_date_of_corrosion_velocity_with_inhibitor_measure'),
                    'type' => 'date',
                ],
                'corrosion_velocity_with_inhibitor' => [
                    'title' => trans('monitoring.corrosion.fields.corrosion_velocity_with_inhibitor'),
                    'type' => 'numeric',
                ],
                'sample_number' => [
                    'title' => trans('monitoring.corrosion.fields.sample_number'),
                    'type' => 'numeric',
                ],
                'weight_before' => [
                    'title' => trans('monitoring.corrosion.fields.weight_before'),
                    'type' => 'numeric',
                ],
                'days' => [
                    'title' => trans('monitoring.corrosion.fields.days'),
                    'type' => 'numeric',
                ],
                'weight_after' => [
                    'title' => trans('monitoring.corrosion.fields.weight_after'),
                    'type' => 'numeric',
                ],
                'avg_speed' => [
                    'title' => trans('monitoring.corrosion.fields.avg_speed'),
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

        return view('сomplicationMonitoring.corrosion.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Corrosion::query()
            ->with('field')
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu');

        $corrosion = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\CorrosionListResource::collection($corrosion)->toJson()));
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
        return view('сomplicationMonitoring.corrosion.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorrosionCreateRequest $request)
    {
        $this->validateFields($request, 'corrosioncrud');

        Corrosion::create($request->validated());
        return redirect()->route('corrosioncrud.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Corrosion $corrosioncrud)
    {
        return view('сomplicationMonitoring.corrosion.show', ['corrosion' => $corrosioncrud]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(Corrosion $corrosion)
    {
        $corrosion->load('history');
        return view('сomplicationMonitoring.corrosion.history', compact('corrosion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Corrosion $corrosioncrud)
    {
        $validationParams = $this->getValidationParams('corrosioncrud');
        return view('сomplicationMonitoring.corrosion.edit', [
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
    public function update(CorrosionUpdateRequest $request, Corrosion $corrosioncrud)
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
    public function destroy(Request $request, Corrosion $corrosioncrud)
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
        return (new CorrosionFilter($query, $filter))->filter();
    }
}

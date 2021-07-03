<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\AgzuFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\AgzuCreateRequest;
use App\Http\Requests\AgzuUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ExportAgzuToExcel;
use App\Models\ComplicationMonitoring\Agzu;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\AgzuListResource;

class AgzuController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'corrosion';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('agzu.list'),
            ],
            'title' => trans('monitoring.agzu.title'),
            'fields' => [               
                'gu_id' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('ovens')
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
                'model' => [
                    'title' => trans('monitoring.buffer_tank.model'),
                    'type' => 'string',
                ],
                'method_of_measurement' => [
                    'title' => trans('monitoring.agzu.method_of_measurement'),
                    'type' => 'string',
                ],
                'number_of_connected_wells' => [
                    'title' => trans('monitoring.agzu.number_of_connected_wells'),
                    'type' => 'numeric',
                ],
                'date_of_exploitation' => [
                    'title' => trans('monitoring.buffer_tank.date_of_exploitation'),
                    'type' => 'date',
                ],
                'current_state' => [
                    'title' => trans('monitoring.buffer_tank.current_state'),
                    'type' => 'string',
                ],
                'date_of_repair' => [
                    'title' => trans('monitoring.buffer_tank.date_of_repair'),
                    'type' => 'date',
                ],
                'type_of_repair' => [
                    'title' => trans('monitoring.buffer_tank.type_of_repair'),
                    'type' => 'string',
                ],
                
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route('agzu.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route('agzu.export');
        }

        return view('complicationMonitoring.agzu.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Agzu::query()
            ->with('gu');

        $agzu = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(AgzuListResource::collection($agzu)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportAgzuToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('agzu');
        return view('complicationMonitoring.agzu.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgzuCreateRequest $request)
    {
        $this->validateFields($request, 'agzu');

        Agzu::create($request->validated());
        return redirect()->route('agzu.store')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Agzu $agzu)
    {
        return view('complicationMonitoring.agzu.show', ['agzu' => $agzu]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(Agzu $agzu)
    {
        $agzu->load('history');
        return view('complicationMonitoring.agzu.history', compact('agzu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Agzu $agzu)
    {
        $validationParams = $this->getValidationParams('agzu');
        return view('complicationMonitoring.agzu.edit', [
            'agzu' => $agzu,
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
    public function update(AgzuUpdateRequest $request, Agzu $agzu)
    {
        $this->validateFields($request, 'agzu');

        $agzu->update($request->validated());
        return redirect()->route('agzu.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Agzu $agzu)
    {
        $agzu->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('agzu.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new AgzuFilter($query, $filter))->filter();
    }
}
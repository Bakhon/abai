<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OvenFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\OvensCreateRequest;
use App\Http\Requests\OvensUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ExportOvensToExcel;
use App\Models\ComplicationMonitoring\Oven;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\OvensListResource;

class OvensController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'corrosion';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('ovens.list'),
            ],
            'title' => trans('monitoring.ovens.title'),
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
                'cipher' => [
                    'title' => trans('monitoring.ovens.cipher'),
                    'type' => 'string',
                ],
                'type' => [
                    'title' => trans('monitoring.buffer_tank.type'),
                    'type' => 'string',
                ],
                'rated_heat_output' => [
                    'title' => trans('monitoring.ovens.rated_heat_output'),
                    'type' => 'string',
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
            $params['links']['create'] = route('ovens.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route('ovens.export');
        }

        return view('complicationMonitoring.ovens.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Oven::query()
            ->with('gu');

        $ovens = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(OvensListResource::collection($ovens)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportOvensToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('ovens');
        return view('complicationMonitoring.ovens.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OvensCreateRequest $request)
    {
        $this->validateFields($request, 'ovens');

        Oven::create($request->validated());
        return redirect()->route('ovens.store')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Oven $ovens)
    {
        return view('complicationMonitoring.ovens.show', ['ovens' => $ovens]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(Oven $ovens)
    {
        $ovens->load('history');
        return view('complicationMonitoring.ovens.history', compact('ovens'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Oven $ovens)
    {
        $validationParams = $this->getValidationParams('ovens');
        return view('complicationMonitoring.ovens.edit', [
            'ovens' => $ovens,
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
    public function update(OvensUpdateRequest $request, Oven $ovens)
    {
        $this->validateFields($request, 'ovens');

        $ovens->update($request->validated());
        return redirect()->route('ovens.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Oven $ovens)
    {
        $ovens->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('ovens.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OvenFilter($query, $filter))->filter();
    }
}
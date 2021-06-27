<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\BufferTankFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\BufferTankCreateRequest;
use App\Http\Requests\BufferTankUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ExportBufferTankToExcel;
use App\Models\ComplicationMonitoring\BufferTank;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\BufferTankListResource;
use App\Models\ComplicationMonitoring\Ngdu;

class BufferTankController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'buffer_tank';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('buffer_tank.list'),
            ],
            'title' => trans('monitoring.buffer_tank.title'),
            'fields' => [
                
                
                'gu_id' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('buffer_tank')
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
                'name' => [
                    'title' => trans('monitoring.buffer_tank.name'),
                    'type' => 'string',
                ],
                'type' => [
                    'title' => trans('monitoring.buffer_tank.type'),
                    'type' => 'string',
                ],
                'volume' => [
                    'title' => trans('monitoring.buffer_tank.volume'),
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
                'external_and_internal_inspection' => [
                    'title' => trans('monitoring.buffer_tank.external_and_internal_inspection'),
                    'type' => 'date',
                ],
                'hydraulic_test' => [
                    'title' => trans('monitoring.buffer_tank.hydraulic_test'),
                    'type' => 'date',
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
            $params['links']['create'] = route('buffer_tank.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route('buffer_tank.export');
        }

        return view('complicationMonitoring.buffer_tank.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        // $query = BufferTank::with('gu');
        $query = BufferTank::query()
            ->with('field')
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu');

        $buffer_tank = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(BufferTankListResource::collection($buffer_tank)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportBufferTankToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('buffer_tank');
        return view('complicationMonitoring.buffer_tank.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BufferTankCreateRequest $request)
    {
        $this->validateFields($request, 'buffer_tank');

        BufferTank::create($request->validated());
        return redirect()->route('buffer_tank.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(BufferTank $buffer_tank)
    {
        return view('complicationMonitoring.buffer_tank.show', ['buffer_tank' => $buffer_tank]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(BufferTank $buffer_tank)
    {
        $buffer_tank->load('history');
        return view('complicationMonitoring.buffer_tank.history', compact('buffer_tank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BufferTank $buffer_tank)
    {
        $validationParams = $this->getValidationParams('buffer_tank');
        return view('complicationMonitoring.buffer_tank.edit', [
            'buffer_tank' => $buffer_tank,
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
    public function update(BufferTankUpdateRequest $request, BufferTank $buffer_tank)
    {
        $this->validateFields($request, 'buffer_tank');

        $buffer_tank->update($request->validated());
        return redirect()->route('buffer_tank.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BufferTank $buffer_tank)
    {
        $buffer_tank->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('buffer_tank.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new BufferTankFilter($query, $filter))->filter();
    }
}
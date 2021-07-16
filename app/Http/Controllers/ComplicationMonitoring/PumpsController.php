<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\PumpsFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\PumpsCreateRequest;
use App\Http\Requests\PumpsUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ExportPumpsToExcel;
use App\Models\ComplicationMonitoring\Pump;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\PumpsListResource;

class PumpsController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'pumps';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('pumps.list'),
            ],
            'title' => trans('monitoring.pumps.title'),
            'fields' => [               
                'gu_id' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('pumps')
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
                'number' => [
                    'title' => trans('monitoring.pumps.number'),
                    'type' => 'string',
                ],
                'model' => [
                    'title' => trans('monitoring.buffer_tank.model'),
                    'type' => 'string',
                ],
                'type' => [
                    'title' => trans('monitoring.buffer_tank.type'),
                    'type' => 'string',
                ],
                'perfomance' => [
                    'title' => trans('monitoring.pumps.perfomance'),
                    'type' => 'numeric',
                ],
                'power' => [
                    'title' => trans('monitoring.pumps.power'),
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
            $params['links']['create'] = route('pumps.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route('pumps.export');
        }

        return view('complicationMonitoring.pumps.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Pump::query()
            ->with('gu');

        $pumps = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(PumpsListResource::collection($pumps)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportPumpsToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    public function create()
    {
        $validationParams = $this->getValidationParams('pumps');
        return view('complicationMonitoring.pumps.create', compact('validationParams'));
    }

    public function store(PumpsCreateRequest $request)
    {
        $this->validateFields($request, 'pumps');

        Pump::create($request->validated());
        return redirect()->route('pumps.store')->with('success', __('app.created'));
    }

    public function show(Pump $pumps)
    {
        return view('complicationMonitoring.pumps.show', ['pumps' => $pumps]);
    }

    public function history(Pump $pumps)
    {
        $pumps->load('history');
        return view('complicationMonitoring.pumps.history', compact('pumps'));
    }

    public function edit(Pump $pumps)
    {
        $validationParams = $this->getValidationParams('pumps');
        return view('complicationMonitoring.pumps.edit', [
            'pumps' => $pumps,
            'validationParams' => $validationParams
        ]);
    }

    public function update(PumpsUpdateRequest $request, Pump $pumps)
    {
        $this->validateFields($request, 'pumps');

        $pumps->update($request->validated());
        return redirect()->route('pumps.index')->with('success', __('app.updated'));
    }

    public function destroy(Request $request, Pump $pumps)
    {
        $pumps->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('pumps.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new PumpsFilter($query, $filter))->filter();
    }
}
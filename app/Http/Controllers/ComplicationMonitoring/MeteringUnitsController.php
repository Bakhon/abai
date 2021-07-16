<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\MeteringUnitsFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\MeteringUnitsCreateRequest;
use App\Http\Requests\MeteringUnitsUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ExportMeteringUnitsToExcel;
use App\Models\ComplicationMonitoring\MeteringUnits;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\MeteringUnitsListResource;

class MeteringUnitsController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'metering_units';

    public function index(): \Illuminate\View\View
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('metering_units.list'),
            ],
            'title' => trans('monitoring.meteringunits.title'),
            'fields' => [               
                'gu_id' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('metering_units')
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
                'type' => [
                    'title' => trans('monitoring.buffer_tank.type'),
                    'type' => 'string',
                ],
                'diameter' => [
                    'title' => trans('monitoring.meteringunits.diameter'),
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
            $params['links']['create'] = route('metering_units.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route('metering_units.export');
        }

        return view('complicationMonitoring.metering_units.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = MeteringUnits::query()
            ->with('gu');

        $meteringunits = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(MeteringUnitsListResource::collection($meteringunits)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportMeteringUnitsToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    public function create()
    {
        $validationParams = $this->getValidationParams('metering_units');
        return view('complicationMonitoring.metering_units.create', compact('validationParams'));
    }

    public function store(MeteringUnitsCreateRequest $request)
    {
        $this->validateFields($request, 'metering_units');

        MeteringUnits::create($request->validated());
        return redirect()->route('metering_units.store')->with('success', __('app.created'));
    }

    public function show(MeteringUnits $meteringunits)
    {
        return view('complicationMonitoring.metering_units.show', ['sib' => $meteringunits]);
    }

    public function history(Sib $meteringunits)
    {
        $meteringunits->load('history');
        return view('complicationMonitoring.metering_units.history', compact('metering_units'));
    }

    public function edit(MeteringUnits $meteringunits)
    {
        $validationParams = $this->getValidationParams('metering_units');
        return view('complicationMonitoring.meteringunits.edit', [
            'metering_units' => $meteringunits,
            'validationParams' => $validationParams
        ]);
    }

    public function update(MeteringUnitsUpdateRequest $request, MeteringUnits $meteringunits)
    {
        $this->validateFields($request, 'metering_units');

        $meteringunits->update($request->validated());
        return redirect()->route('metering_units.index')->with('success', __('app.updated'));
    }

    public function destroy(Request $request, MeteringUnits $meteringunits)
    {
        $meteringunits->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('metering_units.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new MeteringUnitsFilter($query, $filter))->filter();
    }
}
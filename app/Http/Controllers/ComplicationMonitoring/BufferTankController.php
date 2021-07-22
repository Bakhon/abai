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

class BufferTankController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'buffer-tank';

    public function index(): \Illuminate\View\View
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

        // if(auth()->user()->can('monitoring create '.$this->modelName)) {
        //     $params['links']['create'] = route('buffer_tank.create');
        // }

        return view('complicationMonitoring.buffer_tank.index', compact('params'));
    }

    public function list(IndexTableRequest $request): \Symfony\Component\HttpFoundation\Response
    {
            $query = BufferTank::query()
            ->with('gu');

        $buffer_tank = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(BufferTankListResource::collection($buffer_tank)->toJson()));
    }

    public function export(IndexTableRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $job = new ExportBufferTankToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    public function create(): \Illuminate\View\View 
    {
        $validationParams = $this->getValidationParams('buffer_tank');
        return view('complicationMonitoring.buffer_tank.create', compact('validationParams'));
    }

    public function store(BufferTankCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->validateFields($request, 'buffer_tank');

        BufferTank::create($request->validated());
        return redirect()->route('buffer_tank.index')->with('success', __('app.created'));
    }

    public function history(BufferTank $buffer_tank): \Illuminate\View\View
    {
        $buffer_tank->load('history');
        return view('complicationMonitoring.buffer_tank.history', compact('buffer_tank'));
    }

    public function edit(BufferTank $buffer_tank): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('buffer_tank');
        return view('complicationMonitoring.buffer_tank.edit', [
            'buffer_tank' => $buffer_tank,
            'validationParams' => $validationParams
        ]);
    }

    public function update(BufferTankUpdateRequest $request, BufferTank $buffer_tank): \Illuminate\Http\RedirectResponse
    {
        $this->validateFields($request, 'buffer_tank');

        $buffer_tank->update($request->validated());
        return redirect()->route('buffer_tank.index')->with('success', __('app.updated'));
    }

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

    protected function getFilteredQuery($filter, $query = null): \Illuminate\Database\Eloquent\Builder
    {
        return (new BufferTankFilter($query, $filter))->filter();
    }
}
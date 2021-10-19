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

    protected $modelName = 'ovens';

    public function index(): \Illuminate\View\View
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

        $params['filter'] = session($this->modelName.'_filter');

        return view('complicationMonitoring.ovens.index', compact('params'));
    }

    public function list(IndexTableRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        parent::list($request);

        $query = Oven::query()
            ->with('gu');

        $ovens = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(OvensListResource::collection($ovens)->toJson()));
    }

    public function export(IndexTableRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $job = new ExportOvensToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('ovens');
        return view('complicationMonitoring.ovens.create', compact('validationParams'));
    }

    public function store(OvensCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->validateFields($request, 'ovens');

        Oven::create($request->validated());
        return redirect()->route('ovens.store')->with('success', __('app.created'));
    }

    public function show(Oven $ovens): \Illuminate\View\View
    {
        return view('complicationMonitoring.ovens.show', ['ovens' => $ovens]);
    }

    public function history(Oven $ovens): \Illuminate\View\View
    {
        $ovens->load('history');
        return view('complicationMonitoring.ovens.history', compact('ovens'));
    }

    public function edit(Oven $ovens): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('ovens');
        return view('complicationMonitoring.ovens.edit', [
            'ovens' => $ovens,
            'validationParams' => $validationParams
        ]);
    }

    public function update(OvensUpdateRequest $request, Oven $ovens): \Illuminate\Http\RedirectResponse
    {
        $this->validateFields($request, 'ovens');

        $ovens->update($request->validated());
        return redirect()->route('ovens.index')->with('success', __('app.updated'));
    }

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

    protected function getFilteredQuery($filter, $query = null): \Illuminate\Database\Eloquent\Builder
    {
        return (new OvenFilter($query, $filter))->filter();
    }
}
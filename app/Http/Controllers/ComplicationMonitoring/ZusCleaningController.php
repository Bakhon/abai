<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\ZusCleaningFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\ZusCleaningCreateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ExportZusCLeaningToExcel;
use App\Models\ComplicationMonitoring\ZusCleaning;
use App\Models\ComplicationMonitoring\Zu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\ZusCleaningListResource;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Support\Facades\Storage;

class ZusCleaningController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'zu-cleanings';

    public function index(): \Illuminate\View\View
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('zu-cleanings.list'),
            ],
            'title' => trans('monitoring.zu_cleanings.title'),
            'fields' => [               
                'gu_id' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('zu_cleanings')
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
                'zu_id' => [
                    'title' => trans('monitoring.zu.zu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Zu::whereHas('zu_cleanings')
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
                'date' => [
                    'title' => trans('monitoring.zu_cleanings.date'),
                    'type' => 'date',
                ],
                'number_of_failures' => [
                    'title' => trans('monitoring.zu_cleanings.number_of_failures'),
                    'type' => 'numeric',
                ],
                'failure_reason' => [
                    'title' => trans('monitoring.zu_cleanings.failure_reason'),
                    'type' => 'string',
                ],        
                'repair_period' => [
                    'title' => trans('monitoring.zu_cleanings.repair_period'),
                    'type' => 'string',
                ],
        
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route('zu-cleanings.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route('zu-cleanings.export');
        }

        return view('complicationMonitoring.zusCleaning.index', compact('params'));
    }

    public function list(IndexTableRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $query = ZusCleaning::query()
            ->with('zu');

        $zu_cleanings = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(ZusCleaningListResource::collection($zu_cleanings)->toJson()));
    }

    public function export(IndexTableRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $job = new ExportZusCleaningToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('zu-cleanings');
        return view('complicationMonitoring.zusCleaning.create', compact('validationParams'));
    }

    public function store(ZusCleaningCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->validateFields($request, 'zu-cleanings');

        ZusCleaning::create($request->validated());
        return redirect()->route('zu-cleanings.index')->with('success', __('app.created'));
    }

    public function show(ZusCleaning $zu_cleanings): \Illuminate\View\View
    {
        return view('complicationMonitoring.zusCleaning.show', ['zu-cleanings' => $zu_cleanings]);
    }

    public function history(ZusCleaning $zu_cleanings): \Illuminate\View\View
    {
        $zu_cleanings->load('history');
        return view('complicationMonitoring.zusCleaning.history', compact('zu_cleamings'));
    }

    public function edit(ZusCleaning $zu_cleanings): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('zu-cleanings');
        return view('complicationMonitoring.zusCleaning.edit', [
            'zu_cleanings' => $zu_cleanings,
            'validationParams' => $validationParams
        ]);
    }

    public function update(ZusCleaningCreateRequest $request, ZusCleaning $zu_cleanings): \Illuminate\Http\RedirectResponse
    {
        $this->validateFields($request, 'zu-cleanings');

        $zu_cleanings->update($request->validated());
        return redirect()->route('zu-cleanings.index')->with('success', __('app.updated'));
    }

    public function destroy(Request $request, ZusCleaning $zu_cleanings)
    {
        $zu_cleanings->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('zu-cleanings.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null): \Illuminate\Database\Eloquent\Builder
    {
        return (new ZusCleaningFilter($query, $filter))->filter();
    }

}
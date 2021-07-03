<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\SibFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\SibCreateRequest;
use App\Http\Requests\SibUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ExportSibToExcel;
use App\Models\ComplicationMonitoring\Sib;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\SibListResource;

class SibController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'corrosion';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('sib.list'),
            ],
            'title' => trans('monitoring.sib.title'),
            'fields' => [               
                'gu_id' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('sib')
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
            $params['links']['create'] = route('sib.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route('sib.export');
        }

        return view('complicationMonitoring.sib.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Sib::query()
            ->with('gu');

        $sib = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(SibListResource::collection($sib)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportSibToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('sib');
        return view('complicationMonitoring.sib.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SibCreateRequest $request)
    {
        $this->validateFields($request, 'sib');

        Sib::create($request->validated());
        return redirect()->route('sib.store')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sib $sib)
    {
        return view('complicationMonitoring.sib.show', ['sib' => $sib]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(Sib $sib)
    {
        $sib->load('history');
        return view('complicationMonitoring.sib.history', compact('sib'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Sib $sib)
    {
        $validationParams = $this->getValidationParams('sib');
        return view('complicationMonitoring.sib.edit', [
            'sib' => $sib,
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
    public function update(SibUpdateRequest $request, Sib $sib)
    {
        $this->validateFields($request, 'sib');

        $sib->update($request->validated());
        return redirect()->route('sib.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Sib $sib)
    {
        $sib->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('sib.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new SibFilter($query, $filter))->filter();
    }
}
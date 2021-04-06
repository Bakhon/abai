<?php

namespace App\Http\Controllers;

use App\Filters\PipeFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\PipeCreateRequest;
use App\Http\Requests\PipeUpdateRequest;
use App\Models\ComplicationMonitoring\Pipe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class PipeController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'pipes';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('pipes.list'),
            ],
            'title' => trans('monitoring.pipe.title'),
            'fields' => [
                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('pipe')
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
                'length' => [
                    'title' => trans('monitoring.pipe.fields.length'),
                    'type' => 'numeric',
                ],
                'outside_diameter' => [
                    'title' => trans('monitoring.pipe.fields.outside_diameter'),
                    'type' => 'numeric',
                ],
                'inner_diameter' => [
                    'title' => trans('monitoring.pipe.fields.inner_diameter'),
                    'type' => 'numeric',
                ],
                'thickness' => [
                    'title' => trans('monitoring.pipe.fields.thickness'),
                    'type' => 'numeric',
                ],
                'roughness' => [
                    'title' => trans('monitoring.pipe.fields.roughness'),
                    'type' => 'numeric',
                ],
                'material' => [
                    'title' => trans('monitoring.pipe.fields.material'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\ComplicationMonitoring\Material::whereHas('pipe')
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
                'plot' => [
                    'title' => trans('monitoring.pipe.fields.plot'),
                    'type' => 'numeric',
                ],
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route($this->modelName.'.export');
        }

        return view('pipes.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Pipe::query()
            ->with('gu');

        $pipe = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\PipeListResource::collection($pipe)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new \App\Jobs\ExportPipesToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('pipes');
        return view('pipes.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PipeCreateRequest $request)
    {
        $this->validateFields($request, 'pipes');
        
        $pipe = Pipe::create($request->validated());
        return redirect()->route('pipes.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pipe $pipe)
    {
        return view('pipes.show', compact('pipe'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(Pipe $pipe)
    {
        $pipe->load('history');
        return view('pipes.history', compact('pipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pipe $pipe)
    {
        $validationParams = $this->getValidationParams('pipes');
        return view('pipes.edit', compact('pipe', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PipeUpdateRequest $request, Pipe $pipe)
    {
        $this->validateFields($request, 'pipes');
        
        $pipe->update($request->validated());
        return redirect()->route('pipes.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Pipe $pipe)
    {
        $pipe->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('pipes.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new PipeFilter($query, $filter))->filter();
    }
}

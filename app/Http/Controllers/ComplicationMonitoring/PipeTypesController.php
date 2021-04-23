<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\PipeTypeFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\PipeTypesRequest;
use App\Http\Resources\PipeTypeListResource;
use App\Models\ComplicationMonitoring\PipeType;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class PipeTypesController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'pipe_types';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('pipe_types.list'),
            ],
            'title' => trans('monitoring.pipe_types.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.pipe_types.fields.name'),
                    'type' => 'numeric',
                ],
                'outside_diameter' => [
                    'title' => trans('monitoring.pipe_types.fields.outside_diameter'),
                    'type' => 'numeric',
                ],
                'inner_diameter' => [
                    'title' => trans('monitoring.pipe_types.fields.inner_diameter'),
                    'type' => 'numeric',
                ],
                'thickness' => [
                    'title' => trans('monitoring.pipe_types.fields.thickness'),
                    'type' => 'numeric',
                ],
                
                
                
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('pipe_types.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = PipeType::with('material');

        $pipe_type = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(PipeTypeListResource::collection($pipe_type)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('pipe_types');
        return view('pipe_types.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PipeTypesRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'pipe_types');

        PipeType::create($request->validated());

        Session::flash('message', __('app.created'));

        return response()->json(
            [
                'status' => config('response.status.success')
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(PipeType $pipe_type): \Illuminate\View\View
    {
        return view('pipe_types.show', compact('pipe_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PipeType $pipe_type): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('pipe_types');
        return view('pipe_types.edit', compact('pipe_type', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(PipeTypesRequest $request, PipeType $pipe_type): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'pipe_types');

        $pipe_type->update($request->validated());

        Session::flash('success', __('app.updated'));

        return response()->json(
            [
                'status' => config('response.status.success')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, PipeType $pipe_type)
    {
        $pipe_type->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('pipe_types.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new PipeTypeFilter($query, $filter))->filter();
    }
}

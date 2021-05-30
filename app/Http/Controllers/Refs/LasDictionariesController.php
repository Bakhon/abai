<?php

namespace App\Http\Controllers\Refs;

use App\Filters\LasDictionariesFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\FileStatusRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class LasDictionariesController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = '';
    protected $model = '';
    protected $resource = '';

    public function index()
    {
        $model_name = $this->modelName;
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route($model_name.'.list'),
            ],
            'title' => trans('monitoring.'.$model_name.'.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.'.$model_name.'.fields.name'),
                    'type' => 'string',
                ]
            ]
        ];
        
        if(auth()->user()->can('monitoring create '.$model_name)) {
            $params['links']['create'] = route($model_name.'.create');
        }

        return view('las_dictionaries.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = $this->model::query();
        $data = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode($this->resource::collection($data)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $model_name = $this->modelName;
        $validationParams = $this->getValidationParams('data');
        return view('las_dictionaries.create', compact('model_name', 'validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileStatusRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'data');

        $this->model::create($request->validated());

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
    public function show(int $id): \Illuminate\View\View
    {
        $model_name = $this->modelName;
        $data = $this->model::find($id);
        return view('las_dictionaries.show', compact('model_name', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Illuminate\View\View
    {
        $data = $this->model::find($id);
        $validationParams = $this->getValidationParams('data');
        $model_name = $this->modelName;
        return view('las_dictionaries.edit', compact('model_name', 'data', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(FileStatusRequest $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'data');

        $this->model::find($id)->update($request->validated());

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
    public function destroy(Request $request, int $id)
    {
        $this->model::find($id)->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route($this->model_name.'.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new LasDictionariesFilter($query, $filter))->filter();
    }
}

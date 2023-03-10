<?php

namespace App\Http\Controllers\Refs\bigdata\mapping;

use App\Filters\LasDictionariesFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Models\BigData\Well;
use App\Models\BigData\Dictionaries\Geo;

class MappingController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = '';
    protected $model = '';
    protected $resource = '';
    protected $link = '';
    protected $view = '';
    protected $queryMethod = '';
    protected $rules = [];

    public function __construct()
    {
        $this->middleware('can:bigdata list '.$this->modelName, ['only' => ['index','list']]);
        $this->middleware('can:bigdata create '.$this->modelName, ['only' => ['create','store']]);
        $this->middleware('can:bigdata read '.$this->modelName, ['only' => ['show']]);
        $this->middleware('can:bigdata update '.$this->modelName, ['only' => ['edit','update']]);
        $this->middleware('can:bigdata delete '.$this->modelName, ['only' => ['destroy']]);
        $this->middleware('can:bigdata export '.$this->modelName, ['only' => ['export']]);
        $this->middleware('can:bigdata view history '.$this->modelName, ['only' => ['history']]);
    }

    public function index()
    {
        $modelName = $this->modelName;
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route($this->link.'.list'),
            ],
            'title' => trans('bd.forms.'.$modelName.'.title'),
            'fields' => [
                'name' => [
                    'title' => trans('bd.forms.geo_mapping.fields.name'),
                    'type' => 'string',
                ],
                'name_in_abai' => [
                    'title' => trans('bd.forms.geo_mapping.fields.geo_name'),
                    'type' => 'string',
                ]
            ]
        ];
        
        if(auth()->user()->can('bigdata create '.$modelName)) {
            $params['links']['create'] = route($this->link.'.create');
        }

        $params['model_name'] = $modelName;
        $params['filter'] = session('las_dictionaries_filter');

        return view($this->view.'.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = $this->model::with($this->queryMethod);
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
        $modelName = $this->modelName;
        $link = $this->link;
        $validationParams = $this->getValidationParams('data');
        $geoList = Geo::where('geo_type', 3)->orderBy('name_ru')->get();
        return view($this->view.'.create', compact('link', 'modelName', 'validationParams', 'geoList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $request->validate($this->rules);
        $this->model::create($request->all());
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
        $modelName = $this->modelName;
        $data = $this->model::find($id);
        $link = $this->link;
        return view($this->view.'.show', compact('link', 'modelName', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Illuminate\View\View
    {
        $data = $this->model::find($id);
        $validationParams = $this->getValidationParams('data');
        $modelName = $this->modelName;
        $link = $this->link;
        $geoList = Geo::where('geo_type', 3)->orderBy('name_ru')->get();
        return view($this->view.'.edit', compact('link', 'modelName', 'data', 'validationParams', 'geoList'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        $request->validate($this->rules);
        $this->model::find($id)->update($request->all());
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
            return redirect()->route($this->link.'.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new LasDictionariesFilter($query, $filter))->filter();
    }
}

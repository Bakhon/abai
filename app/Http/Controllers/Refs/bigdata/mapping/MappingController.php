<?php

namespace App\Http\Controllers\Refs\bigdata\mapping;

use App\Filters\LasDictionariesFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\WellMappingRequest;
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
        $view = $this->view;
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route($this->link.'.list'),
            ],
            'title' => trans('bd.forms.'.$modelName.'.title'),
            'fields' => [
                'name' => [
                    'title' => trans('bd.forms.'.$modelName.'.fields.name'),
                    'type' => 'string',
                ],
                'well_name' => [
                    'title' => trans('bd.well'),
                    'type' => 'string',
                ]
            ]
        ];
        
        if(auth()->user()->can('bigdata create '.$modelName)) {
            $params['links']['create'] = route($this->link.'.create');
        }

        return view($view.'.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = $this->model::with('geo');
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
        $link = $this -> link;
        $validationParams = $this->getValidationParams('data');
        $view = $this->view;
        $geoList = Geo::where('geo_type', 1)->orderBy('name_ru')->get();
        return view($view.'.create', compact('link', 'modelName', 'validationParams', 'geoList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WellMappingRequest $request): \Symfony\Component\HttpFoundation\Response
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
        $modelName = $this->modelName;
        $data = $this->model::find($id);
        $link = $this -> link;
        $view = $this->view;
        return view($view.'.show', compact('link', 'modelName', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Illuminate\View\View
    {
        $data = $this->model::find($id);
        $validationParams = $this->getValidationParams('data');
        $modelName = $this->modelName;
        $link = $this -> link;
        $view = $this->view;
        return view($view.'.edit', compact('link', 'modelName', 'data', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(WellMappingRequest $request, int $id): \Symfony\Component\HttpFoundation\Response
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
            return redirect()->route($this->link.'.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new LasDictionariesFilter($query, $filter))->filter();
    }
}

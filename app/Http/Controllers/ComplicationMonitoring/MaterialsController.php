<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\MaterialFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\MaterialsRequest;
use App\Http\Resources\MaterialListResources;
use App\Models\ComplicationMonitoring\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class MaterialsController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'materials';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('materials.list'),
            ],
            'title' => trans('monitoring.materials.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.materials.fields.material'),
                    'type' => 'numeric',
                ],
                
                'yield_point' => [
                    'title' => trans('monitoring.materials.fields.yield_point'),
                    'type' => 'numeric',
                ],

                'roughness' => [
                    'title' => trans('monitoring.materials.fields.roughness'),
                    'type' => 'numeric',
                ],
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('materials.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Material::with('material');

        $material = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(MaterialListResources::collection($material)->toJson()));
    }

    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('materials');
        return view('materials.create', compact('validationParams'));
    }

    public function store(MaterialsRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'materials');

        Material::create($request->validated());

        Session::flash('message', __('app.created'));

        return response()->json(
            [
                'status' => config('response.status.success')
            ]
        );
    }

    public function show(Material $material): \Illuminate\View\View
    {
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('materials');
        return view('materials.edit', compact('material', 'validationParams'));
    }

    public function update(MaterialsRequest $request, Material $material): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'materials');

        $material->update($request->validated());

        Session::flash('success', __('app.updated'));

        return response()->json(
            [
                'status' => config('response.status.success')
            ]
        );
    }

    public function destroy(Request $request, Material $material)
    {
        $material->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('materials.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new MaterialFilter($query, $filter))->filter();
    }
}

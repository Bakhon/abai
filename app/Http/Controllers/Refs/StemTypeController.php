<?php

namespace App\Http\Controllers\Refs;

use App\Filters\FileStatusFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\StemTypeRequest;
use App\Http\Resources\StemTypeResource;
use App\Models\BigData\Dictionaries\StemType;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class StemTypeController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'stem_type';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('stem_type.list'),
            ],
            'title' => trans('monitoring.stem_type.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.stem_type.fields.name'),
                    'type' => 'string',
                ]
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('stem_type.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = StemType::query();

        $stem_type = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(StemTypeResource::collection($stem_type)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('stem_type');
        return view('stem_type.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StemTypeRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'stem_type');

        StemType::create($request->validated());

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
    public function show(StemType $stem_type): \Illuminate\View\View
    {
        return view('stem_type.show', compact('stem_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StemType $stem_type): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('stem_type');
        return view('stem_type.edit', compact('stem_type', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(StemTypeRequest $request, StemType $stem_type): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'stem_type');

        $stem_type->update($request->validated());

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
    public function destroy(Request $request, StemType $stem_type)
    {
        $stem_type->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('stem_type.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new FileStatusFilter($query, $filter))->filter();
    }
}

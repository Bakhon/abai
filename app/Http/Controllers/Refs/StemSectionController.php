<?php

namespace App\Http\Controllers\Refs;

use App\Filters\FileStatusFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\StemSectionRequest;
use App\Http\Resources\StemSectionResource;
use App\Models\BigData\Dictionaries\StemSection;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class StemSectionController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'stem_section';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('stem_section.list'),
            ],
            'title' => trans('monitoring.stem_section.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.stem_section.fields.name'),
                    'type' => 'string',
                ]
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('stem_section.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = StemSection::query();

        $stem_section = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(StemSectionResource::collection($stem_section)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('stem_section');
        return view('stem_section.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StemSectionRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'stem_section');

        StemSection::create($request->validated());

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
    public function show(StemSection $stem_section): \Illuminate\View\View
    {
        return view('stem_section.show', compact('stem_section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StemSection $stem_section): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('stem_section');
        return view('stem_section.edit', compact('stem_section', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(StemSectionRequest $request, StemSection $stem_section): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'stem_section');

        $stem_section->update($request->validated());

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
    public function destroy(Request $request, StemSection $stem_section)
    {
        $stem_section->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('stem_section.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new FileStatusFilter($query, $filter))->filter();
    }
}

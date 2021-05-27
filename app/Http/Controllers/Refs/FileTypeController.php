<?php

namespace App\Http\Controllers\Refs;

use App\Filters\FileStatusFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\FileTypeRequest;
use App\Http\Resources\FileTypeListResource;
use App\Models\BigData\Dictionaries\FileType;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class FileTypeController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'file_type';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('file_type.list'),
            ],
            'title' => trans('monitoring.file_type.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.file_type.fields.name'),
                    'type' => 'string',
                ]
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('file_type.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = FileType::query();

        $file_type = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(FileTypeListResource::collection($file_type)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('file_type');
        return view('file_type.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileTypeRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'file_type');

        FileType::create($request->validated());

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
    public function show(FileType $file_type): \Illuminate\View\View
    {
        return view('file_type.show', compact('file_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileType $file_type): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('file_type');
        return view('file_type.edit', compact('file_type', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(FileTypeRequest $request, FileType $file_type): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'file_type');

        $file_type->update($request->validated());

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
    public function destroy(Request $request, FileType $file_type)
    {
        $file_type->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('file_type.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new FileStatusFilter($query, $filter))->filter();
    }
}

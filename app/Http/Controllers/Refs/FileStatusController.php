<?php

namespace App\Http\Controllers\Refs;

use App\Filters\FileStatusFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\FileStatusRequest;
use App\Http\Resources\FileStatusListResource;
use App\Models\BigData\Dictionaries\FileStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class FileStatusController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'file_status';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('file_status.list'),
            ],
            'title' => trans('monitoring.file_status.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.file_status.fields.name'),
                    'type' => 'string',
                ]
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('file_status.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = FileStatus::query();

        $file_status = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(FileStatusListResource::collection($file_status)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('file_status');
        return view('file_status.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileStatusRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'file_status');

        FileStatus::create($request->validated());

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
    public function show(FileStatus $file_status): \Illuminate\View\View
    {
        return view('file_status.show', compact('file_status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileStatus $file_status): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('file_status');
        return view('file_status.edit', compact('file_status', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(FileStatusRequest $request, FileStatus $file_status): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'file_status');

        $file_status->update($request->validated());

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
    public function destroy(Request $request, FileStatus $file_status)
    {
        $file_status->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('file_status.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new FileStatusFilter($query, $filter))->filter();
    }
}

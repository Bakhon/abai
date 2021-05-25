<?php

namespace App\Http\Controllers\Refs;

use App\Filters\FileStatusFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\RecordingMethodRequest;
use App\Http\Resources\RecordingMethodResource;
use App\Models\BigData\Dictionaries\RecordingMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class RecordingMethodController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'recording_method';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('recording_method.list'),
            ],
            'title' => trans('monitoring.recording_method.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.recording_method.fields.name'),
                    'type' => 'string',
                ]
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('recording_method.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = RecordingMethod::query();

        $recording_method = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(RecordingMethodResource::collection($recording_method)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('recording_method');
        return view('recording_method.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecordingMethodRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'recording_method');

        RecordingMethod::create($request->validated());

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
    public function show(RecordingMethod $recording_method): \Illuminate\View\View
    {
        return view('recording_method.show', compact('recording_method'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecordingMethod $recording_method): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('recording_method');
        return view('recording_method.edit', compact('recording_method', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(RecordingMethodRequest $request, RecordingMethod $recording_method): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'recording_method');

        $recording_method->update($request->validated());

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
    public function destroy(Request $request, RecordingMethod $recording_method)
    {
        $recording_method->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('recording_method.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new FileStatusFilter($query, $filter))->filter();
    }
}

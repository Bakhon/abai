<?php

namespace App\Http\Controllers\Refs;

use App\Filters\FileStatusFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\RecordingStateRequest;
use App\Http\Resources\RecordingStateResource;
use App\Models\BigData\Dictionaries\RecordingState;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class RecordingStateController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'recording_state';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('recording_state.list'),
            ],
            'title' => trans('monitoring.recording_state.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.recording_state.fields.name'),
                    'type' => 'string',
                ]
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }

        return view('recording_state.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = RecordingState::query();

        $recording_state = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(RecordingStateResource::collection($recording_state)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('recording_state');
        return view('recording_state.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecordingStateRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'recording_state');

        RecordingState::create($request->validated());

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
    public function show(RecordingState $recording_state): \Illuminate\View\View
    {
        return view('recording_state.show', compact('recording_state'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecordingState $recording_state): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('recording_state');
        return view('recording_state.edit', compact('recording_state', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(RecordingStateRequest $request, RecordingState $recording_state): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'recording_state');

        $recording_state->update($request->validated());

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
    public function destroy(Request $request, RecordingState $recording_state)
    {
        $recording_state->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('recording_state.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new FileStatusFilter($query, $filter))->filter();
    }
}

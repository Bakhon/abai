<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\GuUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ExportOmgCAToExcel;
use App\Models\Refs\Gu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class GusController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'gu';

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('gus.list'),
            ],
            'title' => __('monitoring.gus.title'),
            'fields' => [
                'cdng' => [
                    'title' => __('monitoring.cdng'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Cdng::whereHas('gu')
                            ->orderBy('name', 'asc')
                            ->get()
                            ->map(
                                function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'name' => $item->name,
                                    ];
                                }
                            )
                            ->toArray()
                    ]
                ],
                'name' => [
                    'title' => __('app.param_name'),
                    'type' => 'number',
                ],
                'lat' => [
                    'title' => __('app.lat'),
                    'type' => 'number',
                ],
                'lon' => [
                    'title' => __('app.lon'),
                    'type' => 'number',
                ],
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route('gus.create');
        }

        return view('gus.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Gu::query()
            ->with('cdng');

        $gus = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\GuListResource::collection($gus)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportOmgCAToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $validationParams = $this->getValidationParams('gu');
        return view('gus.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(\App\Http\Requests\GuCreateRequest $request)
    {
        $this->validateFields($request, 'gu');

        Gu::create($request->validated());

        return redirect()->route('gus.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function history(Gu $gu)
    {
        $gu->load('history');
        return view('gus.history', compact('gu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function edit(Gu $gu)
    {
        $validationParams = $this->getValidationParams('gu');

        return view('gus.edit', compact('gu', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GuUpdateRequest $request, Gu $gu)
    {
        $this->validateFields($request, 'gu');

        $gu->update($request->validated());
        return redirect()->route('gus.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $omgca = Gu::find($id);
        $omgca->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('gus.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new \App\Filters\GuFilter($query, $filter))->filter();
    }

    public function createExcel()
    {

    }
}

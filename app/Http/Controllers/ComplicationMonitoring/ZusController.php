<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\ZuFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\ZuCreateRequest;
use App\Http\Requests\ZuUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\ZuListResource;
use App\Jobs\ExportOmgCAToExcel;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\Zu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class ZusController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'zu';

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('zus.list'),
            ],
            'title' => __('monitoring.zus.title'),
            'fields' => [
                'gu' => [
                    'title' => __('monitoring.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::query()
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
            $params['links']['create'] = route('zus.create');
        }

        return view('zus.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Zu::query()
            ->with('gu');

        $zus = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(ZuListResource::collection($zus)->toJson()));
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
        $validationParams = $this->getValidationParams('zu');
        return view('zus.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ZuCreateRequest $request)
    {
        $this->validateFields($request, 'zu');

        Zu::create($request->validated());

        return redirect()->route('zus.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function history(Zu $zu)
    {
        $zu->load('history');
        return view('zus.history', compact('zu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function edit(Zu $zu)
    {
        $validationParams = $this->getValidationParams('zu');

        return view('zus.edit', compact('zu', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ZuUpdateRequest $request, Zu $zu)
    {
        $this->validateFields($request, 'zu');

        $zu->update($request->validated());
        return redirect()->route('zus.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $omgca = Zu::find($id);
        $omgca->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('zus.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new ZuFilter($query, $filter))->filter();
    }
}

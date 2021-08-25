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
use App\Models\ComplicationMonitoring\ManualZu;
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

        $params['model_name'] = $this->modelName;
        $params['filter'] = session($this->modelName.'_filter');

        return view('zus.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        parent::list($request);

        $query = Zu::query()
            ->with('gu');

        $zus = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(ZuListResource::collection($zus)->toJson()));
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

        ManualZu::create($request->validated());

        return redirect()->route('zus.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function history(int $id)
    {
        $zu = $id >= 10000 ? ManualZu::find($id) : Zu::find($id);
        $zu->load('history');
        return view('zus.history', compact('zu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $zu = $id >= 10000 ? ManualZu::find($id) : Zu::find($id);
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
    public function update(ZuUpdateRequest $request, int $id)
    {
        if (!auth()->user()->hasPermissionTo('monitoring update zu', 'web')) {
            return redirect()->route('zus.index')->with('error', __('app.no_permissions_rights'));
        }

        $this->validateFields($request, 'zu');
        $zu = $id >= 10000 ? ManualZu::find($id) : Zu::find($id);

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
        if (!auth()->user()->hasPermissionTo('monitoring delete zu', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $zu = $id >= 10000 ? ManualZu::find($id) : Zu::find($id);

        $zu->delete();

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

    public function getAllZu(): \Symfony\Component\HttpFoundation\Response
    {
        $zus = Zu::get();
        $manualZus = ManualZu::get();

        $zus = $zus->merge($manualZus);

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $zus
            ]
        );
    }

    public function getZu(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $zu = Zu::where('gu_id', $request->gu_id)->get();
        $zuManual = ManualZu::where('gu_id', $request->gu_id)->get();

        $zu = $zu->merge($zuManual);

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $zu
            ]
        );
    }

    public function getZuRelations(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $zu = $request->zu_id >= 10000 ?
            ManualZu::with('wells')->find($request->zu_id) :
            Zu::with('wells')->find($request->zu_id);

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $zu
            ]
        );
    }
}

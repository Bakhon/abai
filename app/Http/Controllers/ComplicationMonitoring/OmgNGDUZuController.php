<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OmgNGDUZuFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OmgNGDUZuRequest;
use App\Http\Resources\OmgNGDUZuListResource;
use App\Models\ComplicationMonitoring\OmgNGDUZu;
use App\Models\ComplicationMonitoring\Zu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class OmgNGDUZuController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'omgngdu_zu';
    protected $routeParentName = 'omgngdu-zu';

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('omgngdu-zu.list'),
            ],
            'title' => trans('monitoring.omgngdu_zu.title'),
            'table_header' => [
                trans('monitoring.selection_node') => 1,
                trans('monitoring.omgngdu_zu.fields.fact_data') => 11,
            ],
            'fields' => [
                'zu' => [
                    'title' => trans('monitoring.zu.zu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => getAllObjectsWithOmgngdu('Zu')
                    ]
                ],
                'date' => [
                    'title' => trans('app.date'),
                    'type' => 'date',
                ],
                'daily_fluid_production' => [
                    'title' => trans('monitoring.omgngdu_well.fields.daily_fluid_production'),
                    'type' => 'numeric',
                ],
                'daily_water_production' => [
                    'title' => trans('monitoring.omgngdu_well.fields.daily_water_production'),
                    'type' => 'numeric',
                ],
                'daily_oil_production' => [
                    'title' => trans('monitoring.omgngdu_well.fields.daily_oil_production'),
                    'type' => 'numeric',
                ],
                'gas_factor' => [
                    'title' => trans('monitoring.omgngdu_well.fields.gas_factor'),
                    'type' => 'numeric',
                ],
                'bsw' => [
                    'title' => trans('monitoring.omgngdu_well.fields.bsw'),
                    'type' => 'numeric',
                ],
                'pressure' => [
                    'title' => trans('monitoring.omgngdu_well.fields.pressure'),
                    'type' => 'numeric',
                ],
                'temperature' => [
                    'title' => trans('monitoring.omgngdu_well.fields.temperature'),
                    'type' => 'numeric',
                ],
                'sg_oil' => [
                    'title' => trans('monitoring.omgngdu_well.fields.sg_oil'),
                    'type' => 'numeric',
                ],
                'sg_gas' => [
                    'title' => trans('monitoring.omgngdu_well.fields.sg_gas'),
                    'type' => 'numeric',
                ],
                'sg_water' => [
                    'title' => trans('monitoring.omgngdu_well.fields.sg_water'),
                    'type' => 'numeric',
                ],
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->routeParentName.'.create');
        }

        $params['model_name'] = $this->modelName;
        $params['filter'] = session($this->modelName.'_filter');

        return view('complicationMonitoring.omgngdu_zu.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        parent::list($request);

        $query = OmgNGDUZu::query()
            ->with('zu', 'manualZu');

        $omgngdu_zu = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(OmgNGDUZuListResource::collection($omgngdu_zu)->toJson()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('omgngdu_zu');
        return view('complicationMonitoring.omgngdu_zu.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(OmgNGDUZuRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'omgngdu_zu');
        $input = $request->validated();
        $input['date'] = Carbon::parse($input['date'])->format('Y-m-d');

        $omgngdu_zu = new OmgNGDUZu;
        $omgngdu_zu->fill($input);
        $omgngdu_zu->cruser_id = auth()->id();
        $omgngdu_zu->save();

        Session::flash('message', __('app.created'));

        return response()->json(
            [
                'status' => config('response.status.success'),
                'message' => __('app.created')
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OmgNGDUZu $omgngdu_zu): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('omgngdu_zu');
        return view('complicationMonitoring.omgngdu_zu.edit', compact('omgngdu_zu', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OmgNGDUZuRequest $request, OmgNGDUZu $omgngdu_zu): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'omgngdu_zu');
        $omgngdu_zu->update($request->validated());
        $omgngdu_zu->cruser_id = auth()->id();
        $omgngdu_zu->save();

        Session::flash('message', __('app.updated'));

        return response()->json(
            [
                'status' => config('response.status.success'),
                'message' => __('app.updated')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OmgNGDUZu $omgngdu_zu)
    {
        $omgngdu_zu->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('omgngdu-zu.index')->with('success', __('app.deleted'));
        }
    }


    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OmgNGDUZuFilter($query, $filter))->filter();
    }

    public function getZusValidationParams (): \Symfony\Component\HttpFoundation\Response
    {
        $validationParams = $this->getValidationParams('omgngdu_zu');

        return response()->json($validationParams);
    }

    public function getOmgNgdu (Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $date = $request->input('date');
        $zu_id = $request->input('zu_id');

        $omgngdu_zu = OmgNGDUZu::where('zu_id', $zu_id)
            ->where('date', $date)->first();

        return response()->json($omgngdu_zu);
    }
}

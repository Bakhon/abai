<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OmgNGDUWellFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OmgNGDUWellRequest;
use App\Http\Resources\OmgNGDUWellListResource;
use App\Models\ComplicationMonitoring\ManualWell;
use App\Models\ComplicationMonitoring\ManualZu;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class OmgNGDUWellController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'omgngdu_well';
    protected $routeParentName = 'omgngdu-well';

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('omgngdu-well.list'),
            ],
            'title' => trans('monitoring.omgngdu_well.title'),
            'table_header' => [
                trans('monitoring.selection_node') => 1,
                trans('monitoring.omgngdu_well.fields.fact_data') => 12,
            ],
            'fields' => [
                'zu' => [
                    'title' => trans('monitoring.zu.zu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => getAllObjectsWithOmgngdu('Zu', 'omgngdu_well')
                    ]
                ],

                'well' => [
                    'title' => trans('monitoring.well.well'),
                    'type' => 'select',
                    'filter' => [
                        'values' => getAllObjectsWithOmgngdu('Well')
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

        return view('omgngdu_well.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        parent::list($request);

        $query = OmgNGDUWell::query()
            ->with('zu', 'well', 'manualWell', 'manualZu');

        $omgngdu_well = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(OmgNGDUWellListResource::collection($omgngdu_well)->toJson()));
    }

    /**
     * Display the specified resource.
    */
    public function history(OmgNGDUWell $omgngdu_well): \Illuminate\View\View
    {
        $omgngdu_well->load('history');
        return view('omgngdu_well.history', compact('omgngdu_well'));
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create(): \Illuminate\View\View
    {
        $validationParams = $this->getValidationParams('omgngdu_well');
        return view('omgngdu_well.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(OmgNGDUWellRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'omgngdu_well');
        $input = $request->validated();
        $input['date'] = Carbon::parse($input['date'])->format('Y-m-d');

        $omgngdu_well = new OmgNGDUWell;
        $omgngdu_well->fill($input);
        $omgngdu_well->cruser_id = auth()->id();
        $omgngdu_well->save();

        Session::flash('message', __('app.created'));

        return response()->json(
            [
                'status' => config('response.status.success'),
                'message' => __('app.created')
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $omgngdu_well = OmgNGDUWell::where('id', $id)
            ->with('zu.gu.ngdu', 'well')
            ->first();

        return view('omgngdu_well.show', compact('omgngdu_well'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OmgNGDUWell $omgngdu_well): \Illuminate\View\View
    {
        $omgngdu_well->load('zu', 'well');
        $validationParams = $this->getValidationParams('omgngdu_well');
        return view('omgngdu_well.edit', compact('omgngdu_well', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OmgNGDUWellRequest $request, OmgNGDUWell $omgngdu_well): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'omgngdu_well');
        $omgngdu_well->update($request->validated());
        $omgngdu_well->cruser_id = auth()->id();
        $omgngdu_well->save();

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
    public function destroy(Request $request, $id)
    {
        $omgngdu_well = OmgNGDUWell::find($id);
        $omgngdu_well->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('omgngdu-well.index')->with('success', __('app.deleted'));
        }
    }


    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OmgNGDUWellFilter($query, $filter))->filter();
    }

    public function getOmgNgdu (Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $date = $request->input('date');
        $well_id = $request->input('well_id');

        $omgngdu_well = OmgNGDUWell::where('well_id', $well_id)
            ->where('date', $date)->first();

        return response()->json($omgngdu_well);
    }
}

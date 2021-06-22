<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OilPipesFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OilPipesCreateRequest;
use App\Http\Requests\OilPipesUpdateRequest;
use App\Http\Resources\OilPipesListResource;
use App\Jobs\ExportOilPipesToExcel;
use App\Models\ComplicationMonitoring\Cdng;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\OilPipes;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use App\Models\Refs\OtherObjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OilPipesController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'oilgas';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('oilpipes.list'),
            ],
            'title' => trans('monitoring.oilpipes.title'),
            'fields' => [
                'name' => [
                    'title' => trans('monitoring.oilpipes_name'),
                    'type' => 'string',
                ],
                'ngdu' => [
                    'title' => trans('monitoring.ngdu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Ngdu::whereHas('oilpipes')
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
                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('oilpipes')
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
                'zu' => [
                    'title' => trans('monitoring.zu.zu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Zu::whereHas('oilpipes')
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
                'well' => [
                    'title' => trans('monitoring.well.well'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Well::whereHas('oilpipes')
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
                'type' => [
                    'title' => trans('monitoring.well.well'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Well::whereHas('oilpipes')
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
                'between_points' => [
                    'title' => trans('monitoring.oilpipes_btw_points'),
                    'type' => 'numeric',
                ],
                'comment' => [
                    'title' => trans('monitoring.oilpipes_comment'),
                    'type' => 'string',
                ],
                'start_point' => [
                    'title' => trans('monitoring.oilpipes_start_point'),
                    'type' => 'numeric',
                ],
                'end_point' => [
                    'title' => trans('monitoring.oilpipes_end_point'),
                    'type' => 'numeric',
                ],
                'material_id' => [
                    'title' => trans('monitoring.oilpipes_material'),
                    'type' => 'numeric',
                ],
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route($this->modelName.'.export');
        }

        return view('complicationMonitoring.oilPipes.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = OilPipes::query()
            // ->with('pipeType')
            ->with('ngdu')
            ->with('gu')
            ->with('zu')
            ->with('well');

        $oilpipes = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        // dd($this);
        return response()->json(json_decode(OilPipesListResource::collection($oilpipes)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportOilPipesToExcel($request->validated());
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validationParams = $this->getValidationParams('oilpipes');
        return view('complicationMonitoring.oilPipes.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OilPipesCreateRequest $request)
    {
        $this->validateFields($request, 'oilpipes');

        $omgngdu = new OilPipes;
        $omgngdu->fill($request->all());
        $omgngdu->save();

        return redirect()->route('oilpipes.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oilpipes = OilPipes::where('id', $id)
            ->orderByDesc('date')
            ->with('ngdu')
            ->with('gu')
            ->with('zu')
            ->with('well')
            ->first();

        return view('complicationMonitoring.oilPipes.show', compact('oilpipes'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(OilPipes $oilpipes)
    {
        $oilpipes->load('history');
        return view('complicationMonitoring.oilPipes.history', compact('oilpipes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OilPipes $oilpipes)
    {
        $validationParams = $this->getValidationParams('oilpipes');
        return view('complicationMonitoring.oilPipes.edit', compact('oilpipes', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OilPipesUpdateRequest $request, OilPipes $oilpipes)
    {
        $this->validateFields($request, 'oilpipes');
        $oilpipes->update($request->validated());
        return redirect()->route('oilpipes.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $row = OilPipes::find($id);
        $row->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('oilpipes.index')->with('success', __('app.deleted'));
        }
    }

    // static function getLastOilPipesData($dt, $gu){
    //     $oilGas = OilGas::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('gas_viscosity_at_20')
    //                     ->first();

    //     $oilGas2 = OilGas::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('carbon_dioxide_in_gas')
    //                     ->first();

    //     $oilGas3 = OilGas::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('oil_viscosity_at_20')
    //                     ->first();

    //     $oilGas5 = OilGas::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('water_density_at_20')
    //                     ->first();

    //     $oilGas6 = OilGas::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('gas_density_at_20')
    //                     ->first();

    //     return [
    //         'gas_viscosity_at_20' => $oilGas->gas_viscosity_at_20,
    //         'carbon_dioxide_in_gas' => $oilGas2->carbon_dioxide_in_gas,
    //         'oil_viscosity_at_20' => $oilGas3->oil_viscosity_at_20,
    //         'water_density_at_20' => $oilGas5->water_density_at_20,
    //         'gas_density_at_20' => $oilGas6->gas_density_at_20,
    //     ];
    // }

    // static function getLastWMData($dt, $gu){
    //     $wm = WaterMeasurement::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('hydrogen_sulfide')
    //                     ->where('hydrogen_sulfide', '!=', 0)
    //                     ->first();

    //     $wm2 = WaterMeasurement::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('carbon_dioxide')
    //                     ->first();

    //     $wm3 = WaterMeasurement::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('hydrocarbonate_ion')
    //                     ->first();

    //     $wm4 = WaterMeasurement::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('sulphate_ion')
    //                     ->first();

    //     $wm5 = WaterMeasurement::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('density')
    //                     ->first();

    //     $wm6 = WaterMeasurement::where('gu_id', $gu)
    //                     ->where('date','<=', $dt)
    //                     ->whereNotNull('chlorum_ion')
    //                     ->first();

    //     return [
    //         'hydrogen_sulfide' => $wm->hydrogen_sulfide,
    //         'carbon_dioxide' => $wm2->carbon_dioxide,
    //         'hydrocarbonate_ion' => $wm3->hydrocarbonate_ion,
    //         'sulphate_ion' => $wm4->sulphate_ion,
    //         'density' => $wm5->density,
    //         'chlorum_ion' => $wm6->chlorum_ion
    //     ];
    // }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OilPipesFilter($query, $filter))->filter();
    }

    // static function getCorrosion($gu)
    // {
    //     $cor = Corrosion::where('gu_id', $gu)
    //         ->whereNotNull('background_corrosion_velocity')
    //         ->orderBy('created_at', 'desc')
    //         ->first();
    //     return $cor ? $cor->background_corrosion_velocity : null;
    // }

}
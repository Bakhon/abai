<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OilGasFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OilGasCreateRequest;
use App\Http\Requests\OilGasUpdateRequest;
use App\Http\Resources\OilGasListResource;
use App\Jobs\ExportOilGasToExcel;
use App\Models\ComplicationMonitoring\Cdng;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use App\Models\Refs\OtherObjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OilGasController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'oilgas';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('oilgas.list'),
            ],
            'title' => trans('monitoring.oil.title'),
            'fields' => [
                'other_objects' => [
                    'title' => trans('monitoring.other_objects'),
                    'type' => 'select',
                    'filter' => [
                        'values' => OtherObjects::whereHas('oilgas')
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
                'ngdu' => [
                    'title' => trans('monitoring.ngdu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Ngdu::whereHas('oilgas')
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
                'cdng' => [
                    'title' => trans('monitoring.cdng'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Cdng::whereHas('oilgas')
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
                        'values' => Gu::whereHas('oilgas')
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
                        'values' => Zu::whereHas('oilgas')
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
                        'values' => Well::whereHas('oilgas')
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
                'date' => [
                    'title' => trans('app.date'),
                    'type' => 'date',
                ],
                'water_density_at_20' => [
                    'title' => trans('monitoring.oil.fields.water_density_at_20'),
                    'type' => 'numeric',
                ],
                'oil_viscosity_at_20' => [
                    'title' => trans('monitoring.oil.fields.oil_viscosity_at_20'),
                    'type' => 'numeric',
                ],
                'oil_viscosity_at_40' => [
                    'title' => trans('monitoring.oil.fields.oil_viscosity_at_40'),
                    'type' => 'numeric',
                ],
                'oil_viscosity_at_50' => [
                    'title' => trans('monitoring.oil.fields.oil_viscosity_at_50'),
                    'type' => 'numeric',
                ],
                'oil_viscosity_at_60' => [
                    'title' => trans('monitoring.oil.fields.oil_viscosity_at_60'),
                    'type' => 'numeric',
                ],
                'hydrogen_sulfide_in_gas' => [
                    'title' => trans('monitoring.oil.fields.hydrogen_sulfide_in_gas'),
                    'type' => 'numeric',
                ],
                'oxygen_in_gas' => [
                    'title' => trans('monitoring.oil.fields.oxygen_in_gas'),
                    'type' => 'numeric',
                ],
                'carbon_dioxide_in_gas' => [
                    'title' => trans('monitoring.oil.fields.carbon_dioxide_in_gas'),
                    'type' => 'numeric',
                ],
                'gas_density_at_20' => [
                    'title' => trans('monitoring.oil.fields.gas_density_at_20'),
                    'type' => 'numeric',
                ],
                'gas_viscosity_at_20' => [
                    'title' => trans('monitoring.oil.fields.gas_viscosity_at_20'),
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

        return view('complicationMonitoring.oilGas.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = OilGas::query()
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well');

        $oilgas = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(OilGasListResource::collection($oilgas)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportOilGasToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('oilgas');
        return view('complicationMonitoring.oilGas.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OilGasCreateRequest $request)
    {
        $this->validateFields($request, 'oilgas');

        $omgngdu = new OilGas;
        $omgngdu->fill($request->all());
        $omgngdu->save();

        return redirect()->route('oilgas.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oilgas = OilGas::where('id', $id)
            ->orderByDesc('date')
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well')
            ->first();

        return view('complicationMonitoring.oilGas.show', compact('oilgas'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(OilGas $oilgas)
    {
        $oilgas->load('history');
        return view('complicationMonitoring.oilGas.history', compact('oilgas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OilGas $oilgas)
    {
        $validationParams = $this->getValidationParams('oilgas');
        return view('complicationMonitoring.oilGas.edit', compact('oilgas', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OilGasUpdateRequest $request, OilGas $oilgas)
    {
        $this->validateFields($request, 'oilgas');
        $oilgas->update($request->validated());
        return redirect()->route('oilgas.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $row = OilGas::find($id);
        $row->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('oilgas.index')->with('success', __('app.deleted'));
        }
    }

    static function getLastOilGasData($dt, $gu){
        $oilGas = OilGas::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('gas_viscosity_at_20')
                        ->first();

        $oilGas2 = OilGas::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('carbon_dioxide_in_gas')
                        ->first();

        $oilGas3 = OilGas::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('oil_viscosity_at_20')
                        ->first();

        $oilGas5 = OilGas::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('water_density_at_20')
                        ->first();

        $oilGas6 = OilGas::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('gas_density_at_20')
                        ->first();

        return [
            'gas_viscosity_at_20' => $oilGas->gas_viscosity_at_20,
            'carbon_dioxide_in_gas' => $oilGas2->carbon_dioxide_in_gas,
            'oil_viscosity_at_20' => $oilGas3->oil_viscosity_at_20,
            'water_density_at_20' => $oilGas5->water_density_at_20,
            'gas_density_at_20' => $oilGas6->gas_density_at_20,
        ];
    }

    static function getLastWMData($dt, $gu){
        $wm = WaterMeasurement::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('hydrogen_sulfide')
                        ->where('hydrogen_sulfide', '!=', 0)
                        ->first();

        $wm2 = WaterMeasurement::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('carbon_dioxide')
                        ->first();

        $wm3 = WaterMeasurement::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('hydrocarbonate_ion')
                        ->first();

        $wm4 = WaterMeasurement::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('sulphate_ion')
                        ->first();

        $wm5 = WaterMeasurement::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('density')
                        ->first();

        $wm6 = WaterMeasurement::where('gu_id', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('chlorum_ion')
                        ->first();

        return [
            'hydrogen_sulfide' => $wm->hydrogen_sulfide,
            'carbon_dioxide' => $wm2->carbon_dioxide,
            'hydrocarbonate_ion' => $wm3->hydrocarbonate_ion,
            'sulphate_ion' => $wm4->sulphate_ion,
            'density' => $wm5->density,
            'chlorum_ion' => $wm6->chlorum_ion
        ];
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OilGasFilter($query, $filter))->filter();
    }

    static function getCorrosion($gu)
    {
        $cor = Corrosion::where('gu_id', $gu)
            ->whereNotNull('background_corrosion_velocity')
            ->orderBy('created_at', 'desc')
            ->first();
        return $cor ? $cor->background_corrosion_velocity : null;
    }

}

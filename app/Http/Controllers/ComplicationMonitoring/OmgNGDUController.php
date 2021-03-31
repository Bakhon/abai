<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OmgNGDUFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OmgNGDUCreateRequest;
use App\Http\Requests\OmgNGDUUpdateRequest;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\GuKormass;
use App\Models\ComplicationMonitoring\Kormass;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgCA;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\OmgNGDUListResource;
use App\Jobs\ExportOmgNGDUToExcel;

class OmgNGDUController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'omgngdu';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('omgngdu.list'),
            ],
            'title' => trans('monitoring.omgngdu.title'),
            'table_header' => [
                trans('monitoring.selection_node') => 1,
                trans('monitoring.omgngdu.fields.fact_data') => 10,
            ],
            'fields' => [



                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('omgngdu')
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
                'daily_fluid_production' => [
                    'title' => trans('monitoring.omgngdu.fields.daily_fluid_production'),
                    'type' => 'numeric',
                ],
                'daily_water_production' => [
                    'title' => trans('monitoring.omgngdu.fields.daily_water_production'),
                    'type' => 'numeric',
                ],
                'daily_oil_production' => [
                    'title' => trans('monitoring.omgngdu.fields.daily_oil_production'),
                    'type' => 'numeric',
                ],
                'daily_gas_production_in_sib' => [
                    'title' => trans('monitoring.omgngdu.fields.daily_gas_production_in_sib'),
                    'type' => 'numeric',
                ],
                'bsw' => [
                    'title' => trans('monitoring.omgngdu.fields.bsw'),
                    'type' => 'numeric',
                ],
                'surge_tank_pressure' => [
                    'title' => trans('monitoring.omgngdu.fields.surge_tank_pressure'),
                    'type' => 'numeric',
                ],
                'pump_discharge_pressure' => [
                    'title' => trans('monitoring.omgngdu.fields.pump_discharge_pressure'),
                    'type' => 'numeric',
                ],
                'heater_inlet_temperature' => [
                    'title' => trans('monitoring.omgngdu.fields.heater_inlet_temperature'),
                    'type' => 'numeric',
                ],
                'heater_output_temperature' => [
                    'title' => trans('monitoring.omgngdu.fields.heater_output_temperature'),
                    'type' => 'numeric',
                ],
            ]
        ];

        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route($this->modelName.'.export');
        }

        return view('omgngdu.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = OmgNGDU::query()
            ->with('field', 'ngdu', 'cdng', 'gu', 'zu', 'well');

        $omgngdu = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(OmgNGDUListResource::collection($omgngdu)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportOmgNGDUToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('omgngdu');
        return view('omgngdu.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OmgNGDUCreateRequest $request)
    {
        $this->validateFields($request, 'omgngdu');

        $omgngdu = new OmgNGDU;
        $omgngdu->fill($request->validated());
        $omgngdu->cruser_id = auth()->id();
        $omgngdu->save();

        return redirect()->route('omgngdu.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $omgngdu = OmgNGDU::where('id', $id)
            ->with('ngdu', 'cdng', 'gu', 'zu', 'well')
            ->first();

        return view('omgngdu.show', compact('omgngdu'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(OmgNGDU $omgngdu)
    {
        $omgngdu->load('history');
        return view('omgngdu.history', compact('omgngdu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OmgNGDU $omgngdu)
    {
        $validationParams = $this->getValidationParams('omgngdu');
        return view('omgngdu.edit', compact('omgngdu', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OmgNGDUUpdateRequest $request, OmgNGDU $omgngdu)
    {
        $this->validateFields($request, 'omgngdu');

        $omgngdu->update($request->validated());
        return redirect()->route('omgngdu.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $omgngdu = OmgNGDU::find($id);
        $omgngdu->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('omgngdu.index')->with('success', __('app.deleted'));
        }
    }

    public function getKormass(Request $request)
    {
        $guKormass = GuKormass::where('gu_id', $request->gu_id)->get();
        $guKormassArray = [];
        foreach ($guKormass as $row) {
            array_push($guKormassArray, $row->kormass_id);
        }
        $kormass = Kormass::wherein('id', $guKormassArray)->get();


        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $kormass
            ]
        );
    }

    public function getGuDataByDay(Request $request)
    {
        $ngdu = OmgNGDU::where('date', '<=', $request->dt)
            ->where('gu_id', $request->gu_id)
            ->whereNotNull('id')
            ->latest()
            ->first();

        $uhe = OmgUHE::where('date', '<=', $request->dt)
            ->where('gu_id', $request->gu_id)
            ->whereNotNull('id')
            ->latest()
            ->first();

        $ca = OmgCA::where('date', Carbon::parse($request->dt)->year . "-01-01")
            ->where('gu_id', $request->gu_id)
            ->first();

        $wmLast = WaterMeasurement::where('gu_id', $request->gu_id)
            ->latest()
            ->first();

        $wmLastCO2 = WaterMeasurement::where('gu_id', $request->gu_id)
            ->whereNotNull('carbon_dioxide')
            ->latest()
            ->first();

        $wmLastH2S = WaterMeasurement::where('gu_id', $request->gu_id)
            ->whereNotNull('hydrogen_sulfide')
            ->latest()
            ->first();

        $wmLastHCO3 = WaterMeasurement::where('gu_id', $request->gu_id)
            ->whereNotNull('hydrocarbonate_ion')
            ->latest()
            ->first();

        $wmLastCl = WaterMeasurement::where('gu_id', $request->gu_id)
            ->whereNotNull('chlorum_ion')
            ->latest()
            ->first();

        $wmLastSO4 = WaterMeasurement::where('gu_id', $request->gu_id)
            ->whereNotNull('sulphate_ion')
            ->latest()
            ->first();

        $oilGas = OilGas::where('date', '<=', $request->dt)
            ->where('gu_id', $request->gu_id)
            ->whereNotNull('id')
            ->latest()
            ->first();

        $lastCorrosion = $this->getLastCorrosion($request->gu_id, $request->dt);

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'ngdu' => $ngdu,
                'uhe' => $uhe,
                'ca' => $ca,
                'wmLastH2S' => $wmLastH2S,
                'wmLastCO2' => $wmLastCO2,
                'wmLastHCO3' => $wmLastHCO3,
                'wmLastCl' => $wmLastCl,
                'wmLast' => $wmLast,
                'wmLastSO4' => $wmLastSO4,
                'oilGas' => $oilGas,
                'lastCorrosion' => $lastCorrosion,

            ]
        );
    }

    public function getProblemGuToday()
    {
        $uhes = OmgUHE::query()
            ->select('gu_id', 'current_dosage')
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->leftJoin('gus', 'gus.id', 'omg_u_h_e_s.gu_id')
            ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
            ->orderBy('gus_name', 'asc')
            ->get();

        $cas = OmgCA::query()
            ->select('gu_id', 'plan_dosage')
            ->where('date', Carbon::now()->startOfYear()->format('Y-m-d'))
            ->get();

        $gus = [];
        foreach($uhes as $uhe) {
            $gus[$uhe->gu_id] = [
                'name' => $uhe->gu->name,
                'current_dosage' => $uhe->current_dosage
            ];
        }

        foreach($cas as $ca) {
            $gus[$ca->gu_id]['plan_dosage'] = $ca->plan_dosage;
        }

        $problemGus = [];
        foreach($gus as $guId => $gu) {
            if(isset($gu['current_dosage']) && isset($gu['plan_dosage']) && $gu['current_dosage'] > $gu['plan_dosage']) {
                $problemGus[] = [
                    'id' => $guId,
                    'name' => $gu['name'],
                    'diff' => round($gu['current_dosage']/($gu['plan_dosage']/100) - 100, 2)
                ];
            }
        }

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'problemGus' => $problemGus
            ]
        );
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OmgNGDUFilter($query, $filter))->filter();
    }

    protected function getLastCorrosion(int $guId, string $date): ?Corrosion
    {
        $lastInhibitorCorrosion = Corrosion::where('gu_id', $guId)
            ->whereNotNull('corrosion_velocity_with_inhibitor')
            ->where('start_date_of_corrosion_velocity_with_inhibitor_measure', '<=', $date)
            ->orderByDesc('start_date_of_corrosion_velocity_with_inhibitor_measure')
            ->first();

        $lastBackgroundCorrosion = Corrosion::where('gu_id', $guId)
            ->whereNotNull('background_corrosion_velocity')
            ->where('start_date_of_background_corrosion', '<=', $date)
            ->orderByDesc('start_date_of_background_corrosion')
            ->first();

        if (is_null($lastInhibitorCorrosion)) {
            return $lastBackgroundCorrosion;
        }

        if (is_null($lastBackgroundCorrosion)) {
            return $lastInhibitorCorrosion;
        }

        if (Carbon::parse($lastInhibitorCorrosion->start_date_of_corrosion_velocity_with_inhibitor_measure) >=
            Carbon::parse($lastBackgroundCorrosion->start_date_of_background_corrosion)) {
            return $lastInhibitorCorrosion;
        } else {
            return $lastBackgroundCorrosion;
        }
    }
}

<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Exports\OmgNGDUExport;
use App\Filters\OmgNGDUFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OmgNGDUUpdateRequest;
use App\Models\ComplicationMonitoring\GuKormass as ComplicationMonitoringGuKormass;
use App\Models\ComplicationMonitoring\Kormass as ComplicationMonitoringKormass;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgCA as ComplicationMonitoringOmgCA;
use App\Models\ComplicationMonitoring\OmgNGDU as ComplicationMonitoringOmgNGDU;
use App\Models\ComplicationMonitoring\OmgUHE as ComplicationMonitoringOmgUHE;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class OmgNGDUController extends Controller
{
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
                'create' => route('omgngdu.create'),
                'list' => route('omgngdu.list'),
                'export' => route('omgngdu.export'),
            ],
            'title' => 'База данных ОМГ НГДУ',
            'table_header' => [
                'Узел отбора' => 6,
                'Фактические данные ОМГ ЦА' => 10,
            ],
            'fields' => [
                'field' => [
                    'title' => 'Месторождение',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Field::whereHas('omgngdu')
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
                    'title' => 'НГДУ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Ngdu::whereHas('omgngdu')
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
                    'title' => 'ЦДНГ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Cdng::whereHas('omgngdu')
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
                    'title' => 'ГУ',
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
                'zu' => [
                    'title' => 'ЗУ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Zu::whereHas('omgngdu')
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
                    'title' => 'Скважина',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Well::whereHas('omgngdu')
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
                    'title' => 'Дата',
                    'type' => 'date',
                ],
                'daily_fluid_production' => [
                    'title' => 'Суточная добыча жидкости, м3/сут',
                    'type' => 'numeric',
                ],
                'daily_water_production' => [
                    'title' => 'Суточная добыча воды, м3/сут',
                    'type' => 'numeric',
                ],
                'daily_oil_production' => [
                    'title' => 'Суточная добыча нефти, т/сут',
                    'type' => 'numeric',
                ],
                'daily_gas_production_in_sib' => [
                    'title' => 'Количество газа в СИБ, ст.м3/сут',
                    'type' => 'numeric',
                ],
                'bsw' => [
                    'title' => 'Обводненность, %',
                    'type' => 'numeric',
                ],
                'surge_tank_pressure' => [
                    'title' => 'Давление в буферной емкости, бар',
                    'type' => 'numeric',
                ],
                'pump_discharge_pressure' => [
                    'title' => 'Давление на выходе насоса, бар',
                    'type' => 'numeric',
                ],
                'heater_inlet_pressure' => [
                    'title' => 'Температура на входе в печь, С',
                    'type' => 'numeric',
                ],
                'heater_output_pressure' => [
                    'title' => 'Температура на выходе из печи, С',
                    'type' => 'numeric',
                ],
            ]
        ];

        return view('omgngdu.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = ComplicationMonitoringOmgNGDU::query()
            ->with('field')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well');

        $omgngdu = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\OmgNGDUListResource::collection($omgngdu)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $query = ComplicationMonitoringOmgNGDU::query()
            ->with('field')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well');

        $omgngdu = $this
            ->getFilteredQuery($request->validated(), $query)
            ->get();

        return Excel::download(new OmgNGDUExport($omgngdu), 'omgngdu.xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('omgngdu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'date' => 'required',
            ]
        );

        $omgngdu = new ComplicationMonitoringOmgNGDU;
        $omgngdu->field_id = $request->field_id ?? null;
        $omgngdu->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : null;
        $omgngdu->cdng_id = ($request->cdng_id) ? $request->cdng_id : null;
        $omgngdu->gu_id = ($request->gu_id) ? $request->gu_id : null;
        $omgngdu->zu_id = ($request->zu_id) ? $request->zu_id : null;
        $omgngdu->well_id = ($request->well_id) ? $request->well_id : null;
        $omgngdu->date = date("Y-m-d H:i", strtotime($request->date));
        $omgngdu->daily_fluid_production = ($request->daily_fluid_production) ? $request->daily_fluid_production : null;
        $omgngdu->daily_water_production = ($request->daily_water_production) ? $request->daily_water_production : null;
        $omgngdu->daily_oil_production = ($request->daily_oil_production) ? $request->daily_oil_production : null;
        $omgngdu->daily_gas_production_in_sib = ($request->daily_gas_production_in_sib) ? $request->daily_gas_production_in_sib : null;
        $omgngdu->bsw = ($request->bsw) ? $request->bsw : null;
        $omgngdu->surge_tank_pressure = ($request->surge_tank_pressure) ? $request->surge_tank_pressure : null;
        $omgngdu->pump_discharge_pressure = ($request->pump_discharge_pressure) ? $request->pump_discharge_pressure : null;
        $omgngdu->heater_inlet_pressure = ($request->heater_inlet_pressure) ? $request->heater_inlet_pressure : null;
        $omgngdu->heater_output_pressure = ($request->heater_output_pressure) ? $request->heater_output_pressure : null;
        $omgngdu->kormass_number = ($request->kormass_number) ? $request->kormass_number : null;
        $omgngdu->pressure = ($request->pressure) ? $request->pressure : null;
        $omgngdu->temperature = ($request->temperature) ? $request->temperature : null;
        $omgngdu->daily_fluid_production_kormass = ($request->daily_fluid_production_kormass) ? $request->daily_fluid_production_kormass : null;
        $omgngdu->cruser_id = Auth::user()->id;
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
        $omgngdu = ComplicationMonitoringOmgNGDU::where('id', '=', $id)
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well')
            ->first();

        return view('omgngdu.show', compact('omgngdu'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(ComplicationMonitoringOmgNGDU $omgngdu)
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
    public function edit(ComplicationMonitoringOmgNGDU $omgngdu)
    {
        return view('omgngdu.edit', compact('omgngdu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OmgNGDUUpdateRequest $request, ComplicationMonitoringOmgNGDU $omgngdu)
    {
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
        $omgngdu = ComplicationMonitoringOmgNGDU::find($id);
        $omgngdu->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('omgngdu.index')->with('success', __('app.deleted'));
        }
    }

    public function getKormass(Request $request)
    {
        $guKormass = ComplicationMonitoringGuKormass::where('gu_id', '=', $request->gu_id)->get();
        $guKormassArray = [];
        foreach ($guKormass as $row) {
            array_push($guKormassArray, $row->kormass_id);
        }
        $kormass = ComplicationMonitoringKormass::wherein('id', $guKormassArray)->get();


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
        $ngdu = ComplicationMonitoringOmgNGDU::where('date', '=', $request->dt)->where(
            'gu_id',
            '=',
            $request->gu_id
        )->first();
        $uhe = ComplicationMonitoringOmgUHE::where('date', '=', $request->dt)->where(
            'gu_id',
            '=',
            $request->gu_id
        )->first();
        $ca = ComplicationMonitoringOmgCA::where('date', '=', "" . date("Y") . "-01-01")->where(
            'gu_id',
            '=',
            $request->gu_id
        )->first();
        $wmLast = WaterMeasurement::where('gu_id', '=', $request->gu_id)->latest()->first();
        $wmLastCO2 = WaterMeasurement::where('gu_id', '=', $request->gu_id)->whereNotNull('carbon_dioxide')->latest(
        )->first();
        $wmLastH2S = WaterMeasurement::where('gu_id', '=', $request->gu_id)->whereNotNull('hydrogen_sulfide')->latest(
        )->first();
        $wmLastHCO3 = WaterMeasurement::where('gu_id', '=', $request->gu_id)->whereNotNull(
            'hydrocarbonate_ion'
        )->latest()->first();
        $wmLastCl = WaterMeasurement::where('gu_id', '=', $request->gu_id)->whereNotNull('chlorum_ion')->latest(
        )->first();
        $wmLastSO4 = WaterMeasurement::where('gu_id', '=', $request->gu_id)->whereNotNull('sulphate_ion')->latest(
        )->first();
        $oilGas = OilGas::where('date', '=', $request->dt)->where('gu_id', '=', $request->gu_id)->first();

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
                'oilGas' => $oilGas
            ]
        );
    }

    public function getProblemGuToday()
    {
        $uhes = ComplicationMonitoringOmgUHE::query()
            ->select('gu_id', 'current_dosage')
            ->where('date', '=', \Carbon\Carbon::now()->format('Y-m-d'))
            ->leftJoin('gus', 'gus.id', '=', 'omg_u_h_e_s.gu_id')
            ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
            ->orderBy('gus_name', 'asc')
            ->get();

        $cas = ComplicationMonitoringOmgCA::query()
            ->select('gu_id', 'plan_dosage')
            ->where('date', '=', \Carbon\Carbon::now()->startOfYear()->format('Y-m-d'))
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
            if($gu['current_dosage'] && $gu['plan_dosage'] && $gu['current_dosage'] > $gu['plan_dosage']) {
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
}

<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OilGasFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OilGasCreateRequest;
use App\Http\Requests\OilGasUpdateRequest;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgCA;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                        'values' => \App\Models\Refs\OtherObjects::whereHas('oilgas')
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
                    'title' => trans('monitoring.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('oilgas')
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
                    'title' => trans('monitoring.well'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Well::whereHas('oilgas')
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

        return view('сomplicationMonitoring.oilGas.index', compact('params'));
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

        return response()->json(json_decode(\App\Http\Resources\OilGasListResource::collection($oilgas)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new \App\Jobs\ExportOilGasToExcel($request->validated());
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
        return view('сomplicationMonitoring.oilGas.create', compact('validationParams'));
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
        $oilgas = OilGas::where('id', '=', $id)
            ->orderByDesc('date')
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well')
            ->first();

        return view('сomplicationMonitoring.oilGas.show', compact('oilgas'));
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
        return view('сomplicationMonitoring.oilGas.history', compact('oilgas'));
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
        return view('сomplicationMonitoring.oilGas.edit', compact('oilgas', 'validationParams'));
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

    public function economic(Request $request)
    {
        $economicNextYear = OmgCA::with('gu')
            ->where('date', '=', date('Y', strtotime('+1 year')) . '-01-01')
            ->where('gu_id', '=', $request->gu)
            ->get();

        $data = [
            [
                'ГУ',
                'Плановая дозировка (ТС-3011), г/м³ (год)',
                'План, техрежим Qв, тыс.м³/год',
                'Плановый расход реагента Qп (ТС-3011), т/год',
                'Плановый расход реагента Qп (ТС-3011), кг/сут',
                'Фоновая скорость коррозии, мм/г',
                'Рекомендуемая дозировка (ТС-3011), г/м3',
                'Расход реагента при рекомендуемой дозировке Qр (ТС-3011), т/год',
                'Экономия при внедрении рекомендации, млн.тенге'
            ]
        ];

        foreach ($economicNextYear as $item) {
            $array = [];
            array_push($array, $item->gu->name);
            array_push($array, round($item->plan_dosage, 2));
            array_push($array, round($item->q_v, 2));
            $cg = $item->plan_dosage * $item->q_v / 1000;
            array_push($array, round($cg, 2));
            $ch = $cg * 2.74;
            array_push($array, round($ch, 2));
            $ck = self::getCorrosion($item->gu->id);
            array_push($array, round($ck, 2));
            if ($ck > 0.1) {
                $ci = 14.177 * log($ck) + 35.222;
                array_push($array, round($ci, 2));
            } else {
                $ci = 0;
                array_push($array, round($ci, 2));
            }
            $cj = $ci * $item->q_v / 1000;
            array_push($array, round($cj, 2));
            $co = ($cg - $cj) * 690000 / 1000000;
            array_push($array, round($co, 2));
            array_push($data, $array);
        }

        return response()->json($data);
    }

    public function economicCurrentYear(Request $request)
    {
        $eco = self::ecoData($request->gu);
        $data2 = [
            [
                'Фактическая дозировка (ТС-3011), г/м³',
                'Ежесуточный расход воды Qв, м³/сут',
                'Рекомендуемая дозировка (ТС-3011), г/м3',
                'Экономия при внедрении рекомендации, тыс.тенге'
            ],
            [
                round($eco['uheDose']/$eco['days'],1),
                round($eco['qv']/$eco['days'],1),
                round($eco['recDose']/$eco['days'],1),
                $eco['result']
            ]
        ];

        $result = [
            'tableData' => $data2,
            'daysEcoCurrent' => $eco['days']
        ];
        return response()->json($result);
    }

    static function ecoData($gu = 38)
    {
        $ngduUheData = DB::table('omg_n_g_d_u_s')
            ->leftJoin(
                'omg_u_h_e_s',
                function ($join) {
                    $join->on('omg_n_g_d_u_s.gu_id', '=', 'omg_u_h_e_s.gu_id')
                        ->on('omg_u_h_e_s.date', '=', 'omg_n_g_d_u_s.date');
                }
            )
            ->leftJoin(
                'pipes',
                function ($join) {
                    $join->on('omg_n_g_d_u_s.gu_id', '=', 'pipes.gu_id')
                        ->where('pipes.plot', '=', 'eg');
                }
            )
            ->where('omg_n_g_d_u_s.gu_id', '=', $gu)
            ->whereNotNull('omg_n_g_d_u_s.date')
            ->whereNotNull('omg_n_g_d_u_s.pump_discharge_pressure')
            ->whereNotNull('omg_n_g_d_u_s.heater_output_pressure')
            ->whereNotNull('omg_n_g_d_u_s.daily_fluid_production')
            ->whereNotNull('omg_n_g_d_u_s.bsw')
            ->whereNotNull('omg_n_g_d_u_s.daily_oil_production')
            ->whereNotNull('omg_u_h_e_s.date')
            ->whereNotNull('omg_u_h_e_s.current_dosage')
            ->select(
                'omg_n_g_d_u_s.date',
                'omg_n_g_d_u_s.gu_id',
                'pipes.outside_diameter',
                'pipes.roughness',
                'pipes.length',
                'pipes.thickness',
                'omg_n_g_d_u_s.pump_discharge_pressure',
                'omg_n_g_d_u_s.heater_output_pressure',
                'omg_n_g_d_u_s.daily_fluid_production',
                'omg_n_g_d_u_s.daily_water_production',
                'omg_n_g_d_u_s.bsw',
                'omg_n_g_d_u_s.daily_gas_production_in_sib',
                'omg_n_g_d_u_s.surge_tank_pressure',
                'omg_n_g_d_u_s.daily_oil_production',
                'omg_u_h_e_s.current_dosage')
            ->get();

        $result = 0;
        $qv = 0;
        $uheDose = 0;
        $recDose = 0;

        foreach($ngduUheData as $row){
            $lastOilGasData = self::getLastOilGasData($row->date, $row->gu_id);
            $lastWMData = self::getLastWMData($row->date, $row->gu_id);
            $dose = self::corrosion(
                $row->bsw,
                40.0000,
                0.0294,
                $row->outside_diameter,
                $row->roughness,
                $row->length,
                $row->thickness,
                $row->pump_discharge_pressure,
                $row->heater_output_pressure,
                $lastWMData['hydrogen_sulfide'],
                $lastWMData['carbon_dioxide'],
                $row->daily_fluid_production,
                $row->bsw,
                $lastWMData['hydrocarbonate_ion'],
                $lastWMData['chlorum_ion'],
                $lastWMData['sulphate_ion'],
                $row->daily_gas_production_in_sib,
                $row->surge_tank_pressure,
                $lastWMData['density'],
                $lastOilGasData['water_density_at_20'],
                $lastOilGasData['gas_density_at_20'],
                $lastOilGasData['oil_viscosity_at_20'],
                $lastOilGasData['gas_viscosity_at_20'],
                $row->daily_oil_production
            );
            $result += ($row->current_dosage/1000 - $dose/1000) * 690 * $row->daily_water_production / 1000;
            $qv += $row->daily_water_production;
            $uheDose += $row->current_dosage;
            $recDose += $dose;
        }

        return [
            'days' => $ngduUheData->count(),
            'result' => round($result, 1),
            'qv' => round($qv, 1),
            'uheDose' => round($uheDose, 1),
            'recDose' => round($recDose, 1)
        ];
    }

    static function getLastOilGasData($dt, $gu){
        $oilGas = OilGas::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('gas_viscosity_at_20')
                        ->first();

        $oilGas2 = OilGas::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('carbon_dioxide_in_gas')
                        ->first();

        $oilGas3 = OilGas::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('oil_viscosity_at_20')
                        ->first();

        $oilGas4 = OilGas::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('gas_viscosity_at_20')
                        ->first();

        $oilGas5 = OilGas::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('water_density_at_20')
                        ->first();

        $oilGas6 = OilGas::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('gas_density_at_20')
                        ->first();

        return [
            'gas_viscosity_at_20' => $oilGas->gas_viscosity_at_20,
            'carbon_dioxide_in_gas' => $oilGas2->carbon_dioxide_in_gas,
            'oil_viscosity_at_20' => $oilGas3->oil_viscosity_at_20,
            'gas_viscosity_at_20' => $oilGas4->gas_viscosity_at_20,
            'water_density_at_20' => $oilGas5->water_density_at_20,
            'gas_density_at_20' => $oilGas6->gas_density_at_20,
        ];
    }

    static function getLastWMData($dt, $gu){
        $wm = WaterMeasurement::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('hydrogen_sulfide')
                        ->first();

        $wm2 = WaterMeasurement::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('carbon_dioxide')
                        ->first();

        $wm3 = WaterMeasurement::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('hydrocarbonate_ion')
                        ->first();

        $wm4 = WaterMeasurement::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('sulphate_ion')
                        ->first();

        $wm5 = WaterMeasurement::where('gu_id', '=', $gu)
                        ->where('date','<=', $dt)
                        ->whereNotNull('density')
                        ->first();

        $wm6 = WaterMeasurement::where('gu_id', '=', $gu)
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

    static function corrosion(
        $WC,
        $GOR1,
        $sigma,
        $do,
        $roughness,
        $l,
        $thickness,
        $P,
        $t_heater,
        $conH2S,
        $conCO2,
        $q_l,
        $H2O,
        $HCO3,
        $Cl,
        $SO4,
        $q_g_sib,
        $P_bufer,
        $rhol,
        $rho_o,
        $rhog,
        $mul,
        $mug,
        $q_o
    ) {
        $q_l = $q_l; // БД ОМГ НГДУ  input in pipesim m3/day
        $WC = $WC;
        $rhol = $rhol; // БД Лабараторная НЕФТИ input in pipesim density dead oil g/cm3
        $rhol = $rhol * 1000;
        $q_l = $q_l / 24.0 / 60.0 / 60.0;
        $GOR1 = $GOR1; // БД ОМГ НГДУ input in pipesim Gas-Oil-Ratio газосодержание на входе в ГУ
        $GOR1 = $GOR1 / 100;
        $q_g_sib = $q_g_sib; // m3/day расход газа в СИБ => БД ОМГ НГДУ
        $q_g_sib = $q_g_sib / 24.0 / 60.0 / 60.0;
        $q_o = $q_o;
        $rho_o = $rho_o;
        $q_o = $q_o * 1000 / $rho_o; // convert from t/day => m3/day
        $q_o = $q_o / 24.0 / 60.0 / 60.0; // convert from m3/day => m3/sec
        $GOR = ($GOR1 * $q_o - $q_g_sib) / $q_o; // газосодержание на выходе с ГУ добоваить переменную q_o

        if ($GOR <= 0) {
            $GOR = 0.001;
            ob_start(); //Start output buffer
            echo "GOR1 x q_o less or equal to q_g_sib";
            $warning = ob_get_contents(); //Grab output
            ob_end_clean(); //Discard output buffer
        }
        $q_g = $q_o * $GOR;
        $rhog = $rhog;
        $m_dotl = $rhol * $q_l;
        $m_dotg = $rhog * $q_g;
        $m_dot = $m_dotl + $m_dotg;
        $x = $m_dotg / $m_dot;
        $mul = $mul; // mm2/m.s БД Лабараторная по нефти и газу
        $mul = $mul / 1000;
        $mug = $mug; // mm2/s БД Лабараторная по нефти и газу
        $mug = $mug / 1000;
        $sigma = $sigma;
        $do = $do; // Наружный диаметр Внутренняя БД константа mm
        $do = $do / 1000; // from mm to m
        $thickness = $thickness; // Внутренняя БД константа thickness  in mm
        $thickness = $thickness / 1000;
        $d = $do - 2 * $thickness;
        $roughness = $roughness;
        $l = $l;
        $P = $P; // БД ОМГ НГДУ bar
        $P_pump = $P; // в точке Е бар
        $P_bufer = $P_bufer;
        $g = 9.81;
        $v_lo = $m_dot / $rhol / (pi() / 4 * $d ** 2);
        $Re_lo = $v_lo * $d * $rhol / $mul; // m/s * m * kg/m3 / (kg/(m.s))
        $A = pow(2.457 * log(1 / (pow(7 / $Re_lo, 0.9) + (0.27 * $roughness / $d))), 16);
        $B = pow(37530 / $Re_lo, 16);
        $f_lo = 8 * pow(pow(8 / $Re_lo, 12) + 1 / (pow($A + $B, 1.5)), 1 / 12);
        $dP_lo = $f_lo * $l / $d * (0.5 * $rhol * $v_lo ** 2);
        $v_go = $m_dot / $rhog / (pi() / 4 * $d ** 2);
        $Re_go = $v_go * $d * $rhog / $mug;
        $A_g = pow(2.457 * log(1 / (pow(7 / $Re_go, 0.9) + (0.27 * $roughness / $d))), 16);
        $B_g = pow(37530 / $Re_go, 16);
        $f_go = 8 * pow(pow(8 / $Re_go, 12) + 1 / (pow($A_g + $B_g, 1.5)), 1 / 12);

        $F = $x ** 0.78 * (1 - $x) ** 0.224;
        $H = ($rhol / $rhog) ** 0.91 * ($mug / $mul) ** 0.19 * (1 - $mug / $mul) ** 0.7;
        $E = (1 - $x) ** 2 + $x ** 2 * ($rhol * $f_go / ($rhog * $f_lo));
        $eh = 1 / (1 + (1 - $x) * $rhog / $x / $rhol);
        $rho_h = $rhol * (1 - $eh) + $rhog * $eh;
        $Q_h = $m_dot / $rho_h;
        $v_h = $Q_h / (pi() / 4 * $d ** 2);
        $Fr = $m_dot ** 2 / ($g * $d * $rho_h ** 2);
        $W = $m_dot ** 2 * $d / $sigma / $rho_h;
        $phi_lo2 = $E + 3.24 * $F * $H / ($Fr ** 0.0454 * $W ** 0.035);
        $dP = $phi_lo2 * $dP_lo;
        $P_final = $P - $dP / 100000;
        $do = $do;
        $di = $d;
        $roughness = $roughness;
        $density = $rho_h;
        $viscosity = $mul;
        $k = 45;
        $k_f = 0.6;
        $k_g = 0.774;
        $to = 298.0;
        $t_heater = $t_heater;
        $ti = 273.0 + $t_heater;
        $c_p = 4184.4;
        $sigma_s = 5.678 * pow(10, -8);
        $epsilon = 0.12;
        $ax = ($di ** 2) * pi() / 4;
        $Z = 1; #depth of pipe in ground
        $h_o = 2 * $k_g / $do / log(2 * $Z + sqrt(4 * $Z ** 2 - $do ** 2) / $do);
        $h_i = 0.023 * $c_p * $m_dot / $ax / pow(($c_p * $viscosity / $k_f), 2 / 3) / pow(
                ($di * $m_dot / $ax / $viscosity),
                0.2
            );
        $R_in = $do / ($h_i * $di);
        $R_1 = 0.5 * $do * log($do / $di) / $k;
        $R_out = 1 / $h_o;
        $U = 1 / ($R_in + $R_1 + $R_out);
        $A = pi() * $do;
        $diff_t = $ti ** 4 - $to ** 4;
        $Q_rad = $l * $sigma_s * $A * $epsilon * (($ti ** 4) - ($to ** 4));
        $Q_conv = $U * $A * $l * ($ti - $to);
        $Q_total = $Q_rad + $Q_conv;
        $t_final = $to + ($ti - $to) * exp(-$U * pi() * $do * $l / $m_dot / $c_p);
        $t_final = $t_final - 273;
        $p = $P_bufer * 100; // from bar to kPa
        $t = 25;
        $conH2S = $conH2S;
        $conH2S_frac = $conH2S * 0.07055;
        $conCO2 = $conCO2;
        $conCO2_frac = $conCO2 * 0.05464;
        $pCO2 = $conCO2_frac / 100 * $p;
        $co2 = $pCO2 / 1000;
        $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in kPa

        if ($pCO2 / $pH2S >= 20) {
            $x = 7.96 - 2320 / ($t + 273);
            $y = $t * 5.55 * pow(10, -3);
            $z = 0.67 * log10($co2);
            $omega = $x - $y + $z;
            $r_a = pow(10, $omega);
            ob_start(); //Start output buffer
            echo "CO2";
            $environment_a = "CO2";
            $output_a = ob_get_contents(); //Grab output
            ob_end_clean();
        } else {
            if ($pCO2 / $pH2S < 20) {
                $r_a = -0.6274 + 16.9875 * $pH2S / 100 + 12.0596 * $pCO2 / 100; // Partial pressure was calculated in bar
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                $output_a = ob_get_contents(); //Grab output
                ob_end_clean();
            }
        }

        if ($r_a > 0.125) {
            if ($conH2S < 17) {
                $dose_a = 14.177 * log($r_a) + 35.222;
            } else {
                if ($conH2S > 17) {
                    $dose_a = 13.137 * log($r_a) + 26.859;
                }
            }
        } else {
            $dose_a = 0;
        }
        $H2O = $H2O;
        $T = 25;
        $P = $P_bufer * 14.503773773;
        $pH2S = $pH2S * 0.1450377377;
        $pCO2 = $pCO2 * 0.1450377377;
        $SO4 = $SO4; // БД Лабораторная по жидкости
        $SO4 = $SO4 * 0.0208;
        $HCO3 = $HCO3; // БД Лабораторная по жидкости
        $HCO3 = $HCO3 * 0.0164;
        $Cl = $Cl; // БД Лабораторная по жидкости
        $Cl = $Cl * 0.0282;
        $pcr_W = 0.54 * $H2O + 12.13;
        $pcr_T = 0.57 * $T + 20;
        $pcr_P = -0.081 * $P + 88;
        $pcr_H2S = -0.54 * $pH2S + 67;
        $pcr_CO2 = -0.63 * $pCO2 + 74;
        $pcr_SO4 = -0.013 * $SO4 + 57;
        $pcr_HCO3 = -0.014 * $HCO3 + 81;
        $pcr_Cl = -0.0007 * $Cl + 9.2;

        $arr = array($pcr_W, $pcr_T, $pcr_P, $pcr_H2S, $pcr_CO2, $pcr_SO4, $pcr_HCO3, $pcr_Cl);
        $PCR = array_sum($arr) / 8;
        $PCR_A = 0.0254 * $PCR;
        $p = $P_pump * 100; // БД ОМГ НГДУ from bar to kPa
        $t_heater = $t_heater; // БД ОМГ НГДУ temperature from Печь taken from database
        $t = $t_heater;
        $conH2S = $conH2S;
        $conH2S_frac = $conH2S * 0.07055;
        $conCO2 = $conCO2;
        $conCO2_frac = $conCO2 * 0.05464; // from mg/l => volumetric fraction
        $pCO2 = $conCO2_frac / 100 * $p;
        $co2 = $pCO2 / 1000;
        $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in kPa//
        $ratio = $pCO2 / $pH2S;

        if ($pCO2 / $pH2S >= 20) {
            $x = 7.96 - 2320 / ($t + 273);
            $y = $t * 5.55 * pow(10, -3);
            $z = 0.67 * log10($co2);
            $omega = $x - $y + $z;
            $r_e = pow(10, $omega);
            ob_start(); //Start output buffer///
            echo "CO2";
            $output_e = ob_get_contents(); //Grab output
            ob_end_clean(); //Discard output buffer
        } else {
            if ($pCO2 / $pH2S < 20) {
                $r_e = -0.6274 + 16.9875 * $pH2S / 100 + 12.0596 * $pCO2 / 100; //Partial pressure calculated in bar
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                $output_e = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }
        }

        if ($r_e > 0.125) {
            if ($conH2S < 17) {
                $dose_e = 14.177 * log($r_e) + 35.222;
                //return $dose;
            } else {
                if ($conH2S > 17) {
                    $dose_e = 13.137 * log($r_e) + 26.859;
                    //return $dose;
                }
            }
        } else {
            $dose_e = 0;
        }
        $H2O = $H2O; // БД ОМГ НГДУ
        $T = $t_heater; // БД ОМГ НГДУ
        $P = $P_pump * 14.503773773; //БД ОМГ НГДУ
        $pH2S = $pH2S * 0.1450377377;
        $pCO2 = $pCO2 * 0.1450377377;
        $SO4 = $SO4; // БД Лабораторная по жидкости
        $SO4 = $SO4 * 0.0208;
        $HCO3 = $HCO3; // БД Лабораторная по жидкости
        $HCO3 = $HCO3 * 0.0164;
        $Cl = $Cl; // БД Лабораторная по жидкости
        $Cl = $Cl * 0.0282;
        $pcr_W = 0.54 * $H2O + 12.13;
        $pcr_T = 0.57 * $T + 20;
        $pcr_P = -0.081 * $P + 88;
        $pcr_H2S = -0.54 * $pH2S + 67;
        $pcr_CO2 = -0.63 * $pCO2 + 74;
        $pcr_SO4 = -0.013 * $SO4 + 57;
        $pcr_HCO3 = -0.014 * $HCO3 + 81;
        $pcr_Cl = -0.0007 * $Cl + 9.2;
        $arr = array($pcr_W, $pcr_T, $pcr_P, $pcr_H2S, $pcr_CO2, $pcr_SO4, $pcr_HCO3, $pcr_Cl);
        $PCR = array_sum($arr) / 8; // mpy
        // Local corrosion rate in point G pipeline
        $PCR_E = 0.0254 * $PCR;
        $p = $P_final * 100; //from bar to kPa
        $t = $t_final;
        $conH2S = $conH2S;
        $conH2S_frac = $conH2S * 0.07055;
        $conCO2 = $conCO2;
        $conCO2_frac = $conCO2 * 0.05464; // from mg/l => volumetric fraction
        $pCO2 = $conCO2_frac * $p / 100;
        $co2 = $pCO2 / 1000;
        $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in kPa
        $ratio = $pCO2 / $pH2S;

        if ($pCO2 / $pH2S >= 20) {
            $x = 7.96 - 2320 / ($t + 273);
            $y = $t * 5.55 * pow(10, -3);
            $z = 0.67 * log10($co2);
            $omega = $x - $y + $z;
            $r_f = pow(10, $omega);
            ob_start(); //Start output buffer
            echo "CO2";
            $output_f = ob_get_contents(); //Grab output
            ob_end_clean(); //Discard output buffer
        } else {
            if ($pCO2 / $pH2S < 20) {
                $r_f = -0.6274 + 16.9875 * $pH2S / 100 + 12.0596 * $pCO2 / 100; //Partial pressure calculated in bar
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                $output_f = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }
        }

        if ($r_f > 0.125) {
            if ($conH2S < 17) {
                $dose_f = 14.177 * log($r_f) + 35.222;
            } else {
                if ($conH2S > 17) {
                    $dose_f = 13.137 * log($r_f) + 26.859;
                }
            }
        } else {
            $dose_f = 0;
        }
        $H2O = $H2O;
        $T = $t_final - 273;
        $P = $P_final * 14.503773773;
        $pH2S = $pH2S * 0.1450377377;
        $pCO2 = $pCO2 * 0.1450377377;
        $SO4 = $SO4; // БД Лабараторная по жидкости
        $SO4 = $SO4 * 0.0208;
        $HCO3 = $HCO3; // БД Лабараторная по жидкости
        $HCO3 = $HCO3 * 0.0164;
        $Cl = $Cl; // БД Лабараторная по жидкости
        $Cl = $Cl * 0.0282;
        $pcr_W = 0.54 * $H2O + 12.13;
        $pcr_T = 0.57 * $T + 20;
        $pcr_P = -0.081 * $P + 88;
        $pcr_H2S = -0.54 * $pH2S + 67;
        $pcr_CO2 = -0.63 * $pCO2 + 74;
        $pcr_SO4 = -0.013 * $SO4 + 57;
        $pcr_HCO3 = -0.014 * $HCO3 + 81;
        $pcr_Cl = -0.0007 * $Cl + 9.2;

        $arr = array($pcr_W, $pcr_T, $pcr_P, $pcr_H2S, $pcr_CO2, $pcr_SO4, $pcr_HCO3, $pcr_Cl);
        $PCR = array_sum($arr) / 8;
        $PCR_F = 0.0254 * $PCR;
        $max_dose = max($dose_a, $dose_e, $dose_f);

        return $max_dose;
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OilGasFilter($query, $filter))->filter();
    }

    static function getCorrosion($gu)
    {
        $cor = Corrosion::where('gu_id', '=', $gu)->orderBy('created_at', 'desc')->first();
        return $cor->background_corrosion_velocity;
    }

}

<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Models\ComplicationMonitoring\ConstantsValue;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgCA;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\Pipe;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\Refs\Ngdu;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OilGasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oilgas = OilGas::orderByDesc('date')
                                ->with('other_objects')
                                ->with('ngdu')
                                ->with('cdng')
                                ->with('gu')
                                ->with('zu')
                                ->with('well')
                                ->paginate(10);



        return view('сomplicationMonitoring.oilGas.index',compact('oilgas'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('сomplicationMonitoring.oilGas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);

        $omgngdu = new OilGas;
        $omgngdu->other_objects_id = ($request->other_objects_id) ? $request->other_objects_id : NULL;
        $omgngdu->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : NULL;
        $omgngdu->cdng_id = ($request->cdng_id) ? $request->cdng_id : NULL;
        $omgngdu->gu_id = ($request->gu_id) ? $request->gu_id : NULL;
        $omgngdu->zu_id = ($request->zu_id) ? $request->zu_id : NULL;
        $omgngdu->well_id = ($request->well_id) ? $request->well_id : NULL;
        $omgngdu->date = date("Y-m-d H:i", strtotime($request->date));
        $omgngdu->water_density_at_20 = ($request->water_density_at_20) ? $request->water_density_at_20 : NULL;
        $omgngdu->oil_viscosity_at_20 = ($request->oil_viscosity_at_20) ? $request->oil_viscosity_at_20 : NULL;
        $omgngdu->oil_viscosity_at_40 = ($request->oil_viscosity_at_40) ? $request->oil_viscosity_at_40 : NULL;
        $omgngdu->oil_viscosity_at_50 = ($request->oil_viscosity_at_50) ? $request->oil_viscosity_at_50 : NULL;
        $omgngdu->oil_viscosity_at_60 = ($request->oil_viscosity_at_60) ? $request->oil_viscosity_at_60 : NULL;
        $omgngdu->hydrogen_sulfide_in_gas = ($request->hydrogen_sulfide_in_gas) ? $request->hydrogen_sulfide_in_gas : NULL;
        $omgngdu->oxygen_in_gas = ($request->oxygen_in_gas) ? $request->oxygen_in_gas : NULL;
        $omgngdu->carbon_dioxide_in_gas = ($request->carbon_dioxide_in_gas) ? $request->carbon_dioxide_in_gas : NULL;
        $omgngdu->gas_density_at_20 = ($request->gas_density_at_20) ? $request->gas_density_at_20 : NULL;
        $omgngdu->gas_viscosity_at_20 = ($request->gas_viscosity_at_20) ? $request->gas_viscosity_at_20 : NULL;
        $omgngdu->save();

        return redirect()->route('oilgas.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = OilGas::find($id);
        $row->delete();

        return redirect()->route('oilgas.index')->with('success',__('app.deleted'));
    }

    public function economic(Request $request){
        $economicNextYear = OmgCA::with('gu')
            ->where('date', '=', '2021-01-01')
            ->where('gu_id', '=', $request->gu)
            ->get();

        $data = [
            [
                'ГУ',
                'Плановая дозировка (ТС-3011)',
                'План, техрежим Qв',
                'Плановый расход реагента Qп (ТС-3011), т/год',
                'Плановый расход реагента Qп (ТС-3011), кг/сут',
                'Фоновая скорост коррозии',
                'Рекомендуемая дозировка (ТС-3011)',
                'Расход реагента при рекомендуемой дозировке Qр (ТС-3011)',
                'Экономия при внедрении рекомендации'
            ]
        ];

        foreach ($economicNextYear as $item){
            $array = [];
            array_push($array, $item->gu->name);
            array_push($array, round($item->plan_dosage,2));
            array_push($array, round($item->q_v,2));
            $cg = $item->plan_dosage * $item->q_v / 1000;
            array_push($array, round($cg,2));
            $ch = $cg * 2.74;
            array_push($array, round($ch,2));
            $ck = self::getCorrosion($item->gu->id);
            array_push($array, round($ck,2));
            if($ck > 0.1){
                $ci = 14.177*log($ck)+35.222;
                array_push($array, round($ci,2));
            }else{
                $ci = 0;
                array_push($array, round($ci,2));
            }
            $cj = $ci*$item->q_v/1000;
            array_push($array, round($cj,2));
            $co = ($cg-$cj)*690000/1000000;
            array_push($array, round($co,2));
            array_push($data,$array);
        }

        return response()->json($data);
    }

    public function economicCurrentYear(Request $request){
        $economicCurrentYear = OmgCA::with('gu')
            ->where('date', '=', '2020-01-01')
            ->where('gu_id', '=', $request->gu)
            ->get();

        $datetime1 = new DateTime("2020-01-01");
        $datetime2 = new DateTime();
        $difference = $datetime1->diff($datetime2);

        $data2 = [
            [
                'ГУ',
                'Плановая дозировка (ТС-3011)',
                'План, техрежим Qв',
                'Плановый расход реагента Qп (ТС-3011), т/год',
                'Плановый расход реагента Qп (ТС-3011), кг/сут',
                'Фоновая скорост коррозии',
                'Рекомендуемая дозировка (ТС-3011)',
                'Расход реагента при рекомендуемой дозировке Qр (ТС-3011)',
                'Экономия при внедрении рекомендации'
            ]
        ];

        foreach ($economicCurrentYear as $item){
            $array = [];
            array_push($array, $item->gu->name);
            array_push($array, $item->plan_dosage);
            array_push($array, $item->q_v);
            $cg = $item->plan_dosage * $item->q_v / 1000;
            array_push($array, ($cg/365) * $difference->d);
            $ch = $cg * 2.74;
            array_push($array, $ch);
            $ck = self::getCorrosion($item->gu->id);
            array_push($array, $ck);
            if($ck > 0.1){
                $ci = 14.177*log($ck)+35.222;
                array_push($array, $ci);
            }else{
                $ci = 0;
                array_push($array, $ci);
            }
            $cj = self::getCalcData($request->gu);
            array_push($array, $cj);
            $co = ($cg-$cj)*690000/1000000;
            array_push($array, $co);
            array_push($data2,$array);
        }

        return response()->json($data2);
    }

    static function getCorrosion($gu){
        $cor = Corrosion::where('gu_id', '=', $gu)->orderBy('created_at', 'desc')->first();
        return $cor->background_corrosion_velocity;
    }

    static function getCalcData($gu){
        $pipe = Pipe::where('gu_id','=',$gu)->first();
        $ngdu = self::getNgduByYear($gu);
        $oilGas = self::getOilGasByYear($gu);
        $wm = self::getWMByYear($gu);

        $dose = self::corrosion(0.0294, 87.5, $pipe->outside_diameter, $pipe->roughness, $pipe->length, $pipe->thickness, $ngdu->pump_discharge_pressure, $ngdu->heater_output_pressure, $wm->hydrogen_sulfide, $wm->carbon_dioxide, $ngdu->daily_fluid_production, $ngdu->bsw, $wm->hydrocarbonate_ion, $wm->chlorum_ion, $wm->sulphate_ion, $ngdu->daily_gas_production_in_sib, $ngdu->surge_tank_pressure, $oilGas->water_density_at_20, $oilGas->gas_density_at_20, $oilGas->oil_viscosity_at_20, $oilGas->gas_viscosity_at_20);

        return $dose;
    }

    static function getOilGasByYear($gu = 73){
        $data = OilGas::select(DB::raw('avg(water_density_at_20) as `water_density_at_20_avg`'), DB::raw('avg(gas_density_at_20) as `gas_density_at_20_avg`'), DB::raw('avg(oil_viscosity_at_20) as `oil_viscosity_at_20_avg`'), DB::raw('avg(gas_viscosity_at_20) as `gas_viscosity_at_20_avg`'), DB::raw("DATE_FORMAT(date, '%Y') dt"))
        ->groupby('dt')
        ->where('gu_id','=', $gu)
        ->having('dt', '=', '2020')
        ->first();

        return $data;
    }

    static function getWMByYear($gu = 73){
        $data = WaterMeasurement::select(DB::raw('avg(hydrogen_sulfide) as `hydrogen_sulfide_avg`'), DB::raw('avg(carbon_dioxide) as `carbon_dioxide_avg`'), DB::raw('avg(hydrocarbonate_ion) as `hydrocarbonate_ion_avg`'), DB::raw('avg(chlorum_ion) as `chlorum_ion_avg`'), DB::raw('avg(sulphate_ion) as `sulphate_ion_avg`'), DB::raw("DATE_FORMAT(date, '%Y') dt"))
        ->groupby('dt')
        ->where('gu_id','=', $gu)
        ->having('dt', '=', '2020')
        ->first();

        return $data;
    }

    static function getNgduByYear($gu = 73){
        $data = OmgNGDU::select(DB::raw('avg(bsw) as `bsw_avg`'), DB::raw('avg(pump_discharge_pressure) as `pump_discharge_pressure_avg`'), DB::raw('avg(heater_output_pressure) as `heater_output_pressure_avg`'), DB::raw('avg(daily_fluid_production) as `daily_fluid_production_avg`'), DB::raw('avg(daily_gas_production_in_sib) as `daily_gas_production_in_sib_avg`'), DB::raw('avg(surge_tank_pressure) as `surge_tank_pressure_avg`'), DB::raw("DATE_FORMAT(date, '%Y') dt"))
        ->groupby('dt')
        ->where('gu_id','=', $gu)
        ->having('dt', '=', '2020')
        ->first();

        return $data;
    }
    static function corrosion($GOR1, $sigma, $do, $roughness, $l, $thickness, $P, $t_heater, $conH2S, $conCO2, $q_l, $H2O, $HCO3, $Cl, $SO4, $q_g_sib, $P_bufer, $rhol, $rhog, $mul, $mug)
    {
        if (true) {
            $q_l = $q_l * 1000 / $rhol; // перевод массового расхода (т/сут) в объемный (м3/сут)
            $q_l = $q_l / 24.0 / 60.0 / 60.0;
            $q_g_sib = $q_g_sib / 24.0 / 60.0 / 60.0; // input in pipesim convert from m3/d to m3/sec
            $GOR=($GOR1*$q_l - $q_g_sib) / $q_l; // газосодержание на выходе с ГУ
            $q_g = $q_l * $GOR;
            $m_dotl = $rhol * $q_l;
            $m_dotg = $rhog * $q_g;
            $m_dot = $m_dotl + $m_dotg;
            $x = $m_dotg / $m_dot;// Наружный диаметр Внутренняя БД константа mm
            $do = $do / 1000; // from mm to m
            $thickness = $thickness / 1000;
            $d = $do - 2 * $thickness;
            $roughness = $roughness / 1000;
            $P_pump = $P; // в точке Е
            $g = 9.81;
            $v_lo = $m_dot/$rhol/(pi()/4*$d**2);
            $Re_lo = $v_lo * $d * $rhol / $mul; // m/s * m * kg/m3 / (kg/(m.s))
            $A = pow(2.457 * log(1 / (pow(7/$Re_lo,0.9)+(0.27 * $roughness / $d))),16);
            $B = pow(37530 / $Re_lo,16);
            $f_lo = 8 * pow(pow(8 / $Re_lo,12) + 1 / (pow($A+$B,1.5)),1 / 12);
            $dP_lo = $f_lo*$l/$d*(0.5*$rhol*$v_lo**2);
            $v_go = $m_dot/$rhog/(pi()/4*$d**2);
            $Re_go = $v_go * $d * $rhog / $mug;
            $A_g = pow(2.457 * log(1 / (pow(7/$Re_go,0.9)+(0.27 * $roughness / $d))),16);
            $B_g= pow(37530 / $Re_go,16);
            $f_go = 8 * pow(pow(8 / $Re_go,12) + 1 / (pow($A_g+$B_g,1.5)),1 / 12);

            $F = $x**0.78*(1-$x)**0.224;
            $H = ($rhol/$rhog)**0.91*($mug/$mul)**0.19*(1 - $mug/$mul)**0.7;
            $E = (1-$x)**2 + $x**2*($rhol*$f_go/($rhog*$f_lo));
            $eh = 1 / (1 + (1 - $x) * $rhog / $x / $rhol);
            $rho_h = $rhol*(1-$eh) + $rhog*$eh;
            $Q_h = $m_dot/$rho_h;
            $v_h = $Q_h/(pi()/4*$d**2);
            $Fr = $m_dot**2 / ($g * $d * $rho_h**2);
            $W = $m_dot**2 * $d / $sigma / $rho_h;
            $phi_lo2 = $E + 3.24*$F*$H/($Fr**0.0454*$W**0.035);
            $dP = $phi_lo2*$dP_lo;
            $P_final = $P - $dP/100000;
            $do = $do;
            $di = $d;
            $roughness = $roughness;
            $density = $rho_h;
            $viscosity = $mul;
            $l = 1000.0;
            $k = 45;
            $k_f = 0.6;
            $k_g = 0.774;
            $to = 288.0;
            $ti = 313.0;
            $c_p = 4184.4;
            $sigma_s = 5.678 * pow(10,-8);
            $epsilon = 0.12;
            $ax = ($di**2) * pi() / 4;
            $Z = 1; #depth of pipe in ground
            $h_o = 2 * $k_g / $do / log(2*$Z + sqrt(4*$Z**2 - $do**2) / $do);
            $h_i = 0.023*$c_p*$m_dot/ $ax / pow(($c_p*$viscosity/$k_f),2/3) / pow(($di*$m_dot/$ax/$viscosity),0.2);
            $R_in = $do / ($h_i * $di);
            $R_1 = 0.5*$do * log($do/$di) / $k;
            $R_out = 1 / $h_o;
            $U = 1 / ($R_in + $R_1 + $R_out);
            $A = pi() * $do;
            $diff_t = $ti**4 - $to**4;
            $Q_rad = $l* $sigma_s * $A * $epsilon * (($ti**4)-($to**4));
            $Q_conv = $U * $A * $l * ($ti - $to);
            $Q_total = $Q_rad + $Q_conv;
            $t_final = $to + ($ti - $to) * exp(-$U * pi() * $do * $l / $m_dot / $c_p);
            $p = $P_bufer * 100; // from bar to kPa
            $t = 25; // БД Лаборатория жидкости, mg/l soluble in water previous was mole fraction ex: 0.0001
            $conH2S_frac = $conH2S * 0.07055;
            $conCO2_frac = $conCO2 * 0.05464;
            $pCO2 = $conCO2_frac / 100 * $p;
            $co2 = $pCO2 / 1000;
            $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in kPa
            $ratio = $pCO2 / $pH2S;

            if ($pCO2 / $pH2S >= 500){
                $x = 7.96 - 2320 / ($t+273);
                $y = $t * 5.55 * pow(10,-3);
                $z = 0.67 * log10($co2);
                $omega = $x - $y + $z;
                $r_a = pow(10,$omega);
                ob_start(); //Start output buffer
                echo "CO2";
                $output_a = ob_get_contents(); //Grab output
                ob_end_clean();
            }
            else if ($pCO2 / $pH2S < 500) {
                $r_a = -0.6274 + 0.01318 * $conCO2 + 0.02397 * $conH2S;
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                $output_a = ob_get_contents(); //Grab output
                ob_end_clean();
            }

            if  ($r_a > 0.125) {
                if ($conH2S < 17) {
                    $dose_a = 22.725 * log($r_a) + 58.968;
                }
                else if ($conH2S > 17) {
                    $dose_a = 26.868 * log($r_a) + 55.783;
                }
            }

            else {
                $dose_a = 0;
            }
            $T = 25; //
            $P = $P_bufer * 14.503773773;
            $pH2S = $pH2S * 0.1450377377;
            $pCO2 = $pCO2 * 0.1450377377;
            $SO4 = $SO4 * 0.0208;
            $HCO3 = $HCO3 * 0.0164;
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
            $PCR = array_sum($arr)/8; // mpy
            // Local corrosion rate in point A
            $PCR_A = 0.0254  * $PCR;
            $p = $P_pump * 100; // БД ОМГ НГДУ from bar to kPa
            $t = $t_heater;
            $conH2S_frac = $conH2S * 0.07055;
            $conCO2_frac = $conCO2 * 0.05464; // from mg/l => volumetric fraction
            $pCO2 = $conCO2_frac / 100 * $p;
            $co2 = $pCO2 / 1000;

            $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in kPa
            $ratio = $pCO2 / $pH2S;

            if ($pCO2 / $pH2S >= 500){
                $x = 7.96 - 2320 / ($t+273);
                $y = $t * 5.55 * pow(10,-3);
                $z = 0.67 * log10($co2);
                $omega = $x - $y + $z;
                $r_e = pow(10,$omega);
                ob_start(); //Start output buffer
                echo "CO2";
                $output_e = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }
            else if ($pCO2 / $pH2S < 500) {
                $r_e = -0.6274 + 0.01318 * $conCO2 + 0.02397 * $conH2S;
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                $output_e = ob_get_contents();
                ob_end_clean();
            }

            if  ($r_e > 0.125) {
                if ($conH2S < 17 ) {
                    $dose_e = 22.725 * log($r_e) + 58.968;
                }
                else if ($conH2S > 17) {
                    $dose_e = 26.868 * log($r_e) + 55.783;
                }
            }

            else {
                $dose_e = 0;
            }
            $T = $t_heater;
            $P = $P_pump * 14.503773773;
            $pH2S = $pH2S * 0.1450377377;
            $pCO2 = $pCO2 * 0.1450377377;
            $SO4 = $SO4 * 0.0208;
            $HCO3 = $HCO3 * 0.0164;
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
            $PCR = array_sum($arr)/8; // mpy
            // Local corrosion rate in point G pipeline
            $PCR_E = 0.0254  * $PCR;
            $p = $P_final * 100; //from bar to kPa
            $t = $t_final;
            $conH2S_frac = $conH2S * 0.07055;
            $conCO2_frac = $conCO2 * 0.05464; // from mg/l => volumetric fraction
            $pCO2 = $conCO2 * $p / 100;

            //convert data to proper type
            $co2 = $pCO2 / 1000;

            $pH2S = $p * $conH2S / 100; // partial pressure H2S in kPa
            $ratio = $pCO2 / $pH2S;

            if ($pCO2 / $pH2S >= 500){
                $x = 7.96 - 2320 / ($t+273);
                $y = $t * 5.55 * pow(10,-3);
                $z = 0.67 * log10($co2);
                $omega = $x - $y + $z;
                $r_f = pow(10,$omega);
                ob_start(); //Start output buffer
                echo "CO2";
                $output_f = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }
            else if ($pCO2 / $pH2S < 500) {
                $r_f = -0.6274 + 0.01318 * $conCO2 + 0.02397 * $conH2S;
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                $output_f = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }

            if  ($r_f > 0.125) {
                if ($conH2S < 17 ) {
                    $dose_f = 22.725 * log($r_f) + 58.968;
                }
                else if ($conH2S > 17) {
                    $dose_f = 26.868 * log($r_f) + 55.783;
                }
            }

            else {
                $dose_f = 0;
            }

            $T = $t_final - 273;
            $P = $P_final * 14.503773773;
            $pH2S = $pH2S * 0.1450377377;
            $pCO2 = $pCO2 * 0.1450377377;
            $SO4 = $SO4 * 0.0208;
            $HCO3 = $HCO3 * 0.0164;
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
            $PCR = array_sum($arr)/8;
            $PCR_F = 0.0254  * $PCR;
            $max_dose = max($dose_a, $dose_e, $dose_f);

        return $max_dose;


        } else {
            return 0;
        }
    }
}

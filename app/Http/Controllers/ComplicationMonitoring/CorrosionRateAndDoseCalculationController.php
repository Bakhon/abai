<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Models\ComplicationMonitoring\Gu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CorrosionRateAndDoseCalculationController extends Controller
{
    public function calculate(Request $request)
    {
        //GU переменная
        $gu_id = $request->gu_id;

        $gu = Gu::find($gu_id);

        $p = $request->P_bufer; // bar
        $t = $request->t_heater_inlet;  //temperature in C
        $conH2S_frac = $request->conH2S * 0.07; // from mg/l => volumetric fraction
        $conCO2_frac = $request->conCO2 * 0.05464; // from mg/l => volumetric fraction
        $pCO2 = $conCO2_frac * $p / 100 ; // measured in bar as per formula
        $co2 = $pCO2 / 10; //convert partial pressure CO2 from bar => MPa

        $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in bar

        if ($gu->name == "ГУ-24") {
            if($request->current_dosage > 0){
                $r_a = 0.045375-0.0004*$request->current_dosage-0.18198*$pCO2+438.4723*$pH2S; //updated formula GU24 case 15.12.2020
            }else{
                $r_a = -0.15107+1.146195*$pCO2-854.1*$pH2S;
            }
        }        
        else if ($gu->name == "ГУ-22") {
            if($request->current_dosage > 0){
                $r_a = 0.3651+0.001705*$request->current_dosage-1.4529*$pCO2+1015.4313*$pH2S; //updated formula GU22 case 15.12.2020
            }else{
                $r_a = 0.3242 - 0.3512 * $pCO2 + 689.7732 * $pH2S; 
            }
        }
        elseif ($gu->name == "ГУ-107") {
            $r_a = 0.0401 + 0.000032408 * $pCO2 - 1.2192 * $pH2S; //updated formula GU107 case 15.12.2020
        }
        else {
            if ($pCO2 / $pH2S >= 20) {
                //if ($pH2S < 0.3){// in kPa
                $x = 7.96 - 2320 / ($t + 273);
                $y = $t * 5.55 * pow(10, -3);
                $z = 0.67 * log10($co2);
                $omega = $x - $y + $z;
                $r_a = pow(10, $omega);
                //return $r;
            } //r = pow(10, (7.96 - 2320 / (t + 273) - 5.55 * 10**(-3) * t + 0.67 * math.log10(co2))
            else {
                if ($pCO2 / $pH2S < 20) {
                    //else if ($pH2S > 0.3){
                    //$r_a = -0.6274 + 0.01318 * $conCO2 + 0.02397 * $conH2S;
                    //Скорость корр = -0,6274+16,9875*p(H2S)+12,0596*p(CO2)
                    $r_a = -0.6274 + 16.9875 * $pH2S / 100 + 12.0596 * $pCO2 / 100; // Partial pressure was calculated in bar
                    //return $r;
                }
            }
        }

        if ($r_a > 0.125) {
            if ($conH2S < 17) {
                $dose_a = 14.177 * log($r_a) + 35.222;
                if($dose_a > 0 && $dose_a < 20){
                    $dose_a = 20;
                }
                //return $dose;
            } 
            else {
                if ($conH2S > 17) {
                    $dose_a = 13.137 * log($r_a) + 26.859;
                    if($dose_a > 0 && $dose_a < 20){
                        $dose_a = 20;
                    }
                    //return $dose;
                }
            }
        } else {
            $dose_a = 0;
        }

        $vdata = [
            'corrosion_rate_mm_per_y_point_A' => round($r_a, 2),
            'dose_mg_per_l_point_A' => round($dose_a),
        ];


        return response()->json($vdata);
    }
}

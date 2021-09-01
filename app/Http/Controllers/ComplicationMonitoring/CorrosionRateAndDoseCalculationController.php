<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Models\ComplicationMonitoring\Gu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CorrosionRateAndDoseCalculationController extends Controller
{
    public function calculate(Request $request)
    {

        $gu = Gu::find($request->gu_id);
        $pressure = $request->P_bufer; 
        $temperature = $request->t_heater_inlet;  
        $conH2S_frac = $request->conH2S * 0.07; 
        $conCO2_frac = $request->conCO2 * 0.05464; 
        $pCO2 = $conCO2_frac * $pressure / 100 ; 
        $co2 = $pCO2 / 10; 
        $pH2S = $pressure * $conH2S_frac / 100; 

        if ($gu->name == "ГУ-24") 
        {
            if($request->current_dosage > 0)
            {
                $corrosion_rate_a = 0.045375-0.0004*$request->current_dosage-0.18198*$pCO2+438.4723*$pH2S; 
            }else
            {
                $corrosion_rate_a = -0.15107+1.146195*$pCO2-854.1*$pH2S;
            }
        }        
        else if ($gu->name == "ГУ-22") 
        {
            if($request->current_dosage > 0)
            {
                $corrosion_rate_a = 0.3651+0.001705*$request->current_dosage-1.4529*$pCO2+1015.4313*$pH2S; 
            }else
            {
                $corrosion_rate_a = 0.3242 - 0.3512 * $pCO2 + 689.7732 * $pH2S; 
            }
        }
        else if ($gu->name == "ГУ-107") 
        {
            $corrosion_rate_a = 0.0401 + 0.000032408 * $pCO2 - 1.2192 * $pH2S; 
        }
        else 
        {
            if ($pCO2 / $pH2S >= 20) 
            {
                $x = 7.96 - 2320 / ($temperature + 273);
                $y = $temperature * 5.55 * pow(10, -3);
                $z = 0.67 * log10($co2);
                $omega = $x - $y + $z;
                $corrosion_rate_a = pow(10, $omega);
            } 
            else 
            {
                if ($pCO2 / $pH2S < 20) 
                {
                    $corrosion_rate_a = -0.6274 + 16.9875 * $pH2S / 100 + 12.0596 * $pCO2 / 100; 
                }
            }
        }

        if ($corrosion_rate_a > 0.125) 
        {
            if ($conH2S_frac < 17) 
            {
                $dose_a = 14.177 * log($corrosion_rate_a) + 35.222;
                if($dose_a > 0 && $dose_a < 20)
                {
                    $dose_a = 20;
                }
            } 
            else 
            {
                if ($conH2S_frac > 17) 
                {
                    $dose_a = 13.137 * log($corrosion_rate_a) + 26.859;
                    if($dose_a > 0 && $dose_a < 20)
                    {
                        $dose_a = 20;
                    }
                }
            }
        } else 
        {
            $dose_a = 0;
        }

        $vdata = [
            'corrosion_rate_mm_per_y_point_A' => abs(round($corrosion_rate_a, 2)),
            'dose_mg_per_l_point_A' => abs(round($dose_a)),
        ];


        return response()->json($vdata);
    }
}

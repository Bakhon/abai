<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Models\BigData\DailyProdOil;
use App\Models\BigData\DailyInjectionOil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\BigData\TechModeInj;

class WellHistoryController extends Controller
{
    public function getProductionHistory($wellId) : array
    {
        if (Cache::has('well_history_' . $wellId)) {
            return Cache::get('well_history_' . $wellId);
        }
   
        $measLiqs = DailyProdOil::where('well', $wellId)
            ->orderBy('date', 'asc')
            ->get();

        $groupedLiq = $measLiqs->groupBy(function($val) {
            return Carbon::parse($val->date)->format('Y');
        });

        $liqByMonths = array();
        foreach($groupedLiq as $yearNumber => $value) {
            $liqByMonths[$yearNumber] = $value->groupBy(function($val) {
                return Carbon::parse($val->date)->format('m');
            });
        }

        $result = array();
        foreach($liqByMonths as $yearNumber => $monthes) {
           foreach($monthes as $monthNumber => $month) {
              $result[$yearNumber][$monthNumber] = array();
              foreach($month as $day) {
                 $date = Carbon::parse($day['date']);
                 array_push($result[$yearNumber][$monthNumber], array (
                    'liq' => round($day['liquid'], 1),
                    'date' => $date->format('Y-m-d'),
                    'liqCut' => round($day['wcut'], 1),
                    'workHours' => round($day['work_hours'], 1),
                    'oil' => round($day['oil'], 1),
                    'liquid_telemetry' => round($day['liquid_telemetry'], 1),
                    'gas' => round($day['gas'], 1),
                    'pbuf' => round($day['pbuf'], 1),
                    'pzat' => round($day['pzat'], 1),
                    'hdin' => round($day['hdin'], 1),
                    'pzab' => round($day['pzab'], 1),
                    'gaz_factor' => round($day['gas_factor'], 1),
                    'p_line' => round($day['p_line'], 1),
                    'temp_head' => round($day['temp_head'], 1),
                    'pump_current' => round($day['pump_current'], 1),
                    'pump_freq' => round($day['pump_freq'], 1),
                    'pump_efficiency' => round($day['pump_efficiency'], 1),
                    'pump_temp' => round($day['pump_temp'], 1),
                    'pump_intk_press' => round($day['pump_intk_press'], 1),
                    'pump_stroke' => round($day['pump_stroke'], 1),
                    'pump_spm' => round($day['pump_spm'], 1),
                 ));
              }
           }
        }    

        Cache::put('well_history_' . $wellId, $result, now()->addDay());
        return $result;
    }

    public function getInjectionHistory($wellId)
    {
        if (Cache::has('well_history_inj_' . $wellId)) {
            return Cache::get('well_history_inj_' . $wellId);
        }

        $measLiqs = DailyInjectionOil::where('well', $wellId)
            ->join('dict.inj_agent_type', 'dmart.daily_inj.agent_type', '=', 'dict.inj_agent_type.id')
            ->orderBy('date', 'asc')
            ->get();

        $groupedLiq = $measLiqs->groupBy(function ($val) {
            return Carbon::parse($val->date)->format('Y');
        });

        $liqByMonths = array();
        foreach ($groupedLiq as $yearNumber => $value) {
            $liqByMonths[$yearNumber] = $value->groupBy(function ($val) {
                return Carbon::parse($val->date)->format('m');
            });
        }

        $result = array();
        foreach ($liqByMonths as $yearNumber => $monthes) {
            foreach ($monthes as $monthNumber => $month) {
                $result[$yearNumber][$monthNumber] = array();
                foreach ($month as $dayNumber => $day) {
                    $date = Carbon::parse($day['date']);
                    array_push($result[$yearNumber][$monthNumber], array(
                        'date' => $date->format('Y-m-d'),
                        'water_inj_val' => round($day['water_inj_val'], 1),
                        'pressure_inj' => round($day['pressure_inj'], 1),
                        'pump_stroke' => round($day['pump_stroke'], 1),
                        'choke' => round($day['choke'], 1),
                        'source' => round($day['source'], 1),
                        'gtm' => round($day['gtm'], 1),
                        'agent_type' => round($day['agent_type'], 1),
                        'water_vol' => round($day['water_vol'], 1),
                        'hdin' => round($day['hdin'], 1),
                        'battery' => round($day['battery'], 1),
                        'workHours' => round($day['work_hours'], 1),
                        'name_short_ru' => $day['name_short_ru'],
                    ));
                }
            }
        }
        Cache::put('well_history_inj_' . $wellId, $result, now()->addDay());
        return $result;
    }

    public function getInjectionTechModeOil(Request $request, $wellId)
    {
        $minYear = min($request->year);
        $maxYear = max($request->year);
        return TechModeInj::query()
            ->select()
            ->whereYear('dbeg', '>=', $minYear)
            ->whereYear('dbeg', '<=', $maxYear)
            ->where('well', $wellId)
            ->get()
            ->toArray();
    }
}

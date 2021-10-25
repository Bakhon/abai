<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Models\BigData\DailyProdOil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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
                    'pzab' => round($day['pzab'], 1)
                 ));
              }
           }
        }

        Cache::put('well_history_' . $wellId, $result, now()->addDay());
        return $result;
    }
}

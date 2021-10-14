<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoPlan;
use Carbon\Carbon;

class ExcelFormPlansController extends Controller
{
    public function getPlansByDzo(Request $request)
    {
        return DzoPlan::query()
            ->whereYear('date', $request->year)
            ->where('dzo', $request->dzo)
            ->get();
    }

    public function storePlans(Request $request)
    {
        $params = $request->request->all();
        $params = reset($params);
        foreach($params['plans'] as $plan) {
            $existRecord = $this->getExistRecord($params['dzo'],Carbon::parse($plan['date']));
            if (!is_null($existRecord)) {
                DzoPlan::create($plan);
                dd($plan);
            }
        }
    }

    private function getExistRecord($dzo,$date)
    {
        return DzoPlan::query()
            ->where('dzo',$dzo)
            ->whereYear('date',$date->year)
            ->whereMonth('date',$date->month)
            ->first();
    }
}

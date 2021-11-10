<?php

namespace App\Http\Controllers\ProductionPlanningMonitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseProductionForecastController extends Controller
{
    public function index()
    {
        return view('prod_plan_mon.base_prod_forecast');
    }
}

<?php

namespace App\Http\Controllers\ProductionPlanningMonitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionPlanningMonitoringController extends Controller
{
    public function index()
    {
        return view('prod_plan_mon.mon_plan_fact');
    }
}

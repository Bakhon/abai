<?php

namespace App\Http\Controllers\ProductionPlanningMonitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionPlanningMonitoringController extends Controller
{
    public function index()
    {
        return view('prod-plan-mon.mon-plan-fact');
    }
}

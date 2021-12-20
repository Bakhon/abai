<?php

namespace App\Http\Controllers\ProdPlanning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BusinessPlanningController extends Controller
{
    public function index()
    {
        return view('prod_planning.bus_plan');
    }
}
<?php

namespace App\Http\Controllers\ProdPlanning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BaseProductionForecastController extends Controller
{
    public function index()
    {
        return view('prod_planning.base_production_forecast');
    }
}
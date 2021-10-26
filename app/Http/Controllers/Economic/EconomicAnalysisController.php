<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EconomicAnalysisController extends Controller
{
    public function index(): View
    {
        return view('economic.analysis.index');
    }

    public function inputParams(): View
    {
        return view('economic.analysis.input_params');
    }
}

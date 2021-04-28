<?php


namespace App\Http\Controllers\Refs;


use App\Http\Controllers\Controller;

class EcoRefsScenarioController extends Controller
{
    public function index()
    {
        return view('eco_refs_scenario.index');
    }
}
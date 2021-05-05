<?php

namespace App\Http\Controllers\tr;

use App\Http\Controllers\Controller;



class TrController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:tr view main')->only('tr', 'fa', 'trfa', 'tr_charts', 'TechMode', 'TechModeSmall');
    }
    public function tr()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();       
        
        return view('tr.tr', compact('permissionNames'));
    }   
    public function fa()
    {
        return view('fa.fa');
    }   
    public function trfa()
    {
        return view('trfa.trfa');
    }    
    public function tr_charts()
    {
        return view('tr_charts.tr_charts');
    } 
    public function TechMode()
    {
        return view('TechMode.TechMode');
    }
    public function TechModeSmall()
    {
        return view('TechModeSmall.TechModeSmall');
    }
    public function FaWeeklyChart()
    {
        return view('FaWeeklyChart.FaWeeklyChart');
    }
}
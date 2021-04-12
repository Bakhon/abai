<?php

namespace App\Http\Controllers\tr;

use App\Http\Controllers\Controller;



class TrController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:tr view main')->only('tr', 'fa', 'trfa', 'tr_charts', 'TechMode');
    }
    public function tr()
    {
        $permissions = auth()->user()->getAllPermissions();

        $permissionNames = [];
        foreach ($permissions as $permission){
            array_push($permissionNames, $permission->name);
        }        
        
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
    public function FaWeeklyChart()
    {
        return view('FaWeeklyChart.FaWeeklyChart');
    }
}
<?php

namespace App\Http\Controllers\tkrs;

use App\Http\Controllers\Controller;



class TkrsController extends Controller
{
    
    public function tkrsMain()
    {
        return view('tkrsMain.tkrsMain');
    } 
    public function hookWeightSensor()
    {
        return view('hookWeightSensor.hookWeightSensor');
    } 
    public function hookWeightSensorAnalyse()
    {
        return view('hookWeightSensorAnalyse.hookWeightSensorAnalyse');
    }  

}
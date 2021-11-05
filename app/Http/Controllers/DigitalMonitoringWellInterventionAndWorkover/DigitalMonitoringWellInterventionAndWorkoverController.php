<?php

namespace App\Http\Controllers\DigitalMonitoringWellInterventionAndWorkover;

use App\Http\Controllers\Controller;



class DigitalMonitoringWellInterventionAndWorkoverController extends Controller
{
    
    public function tkrsMain()
    {
        return view('DigitalMonitoringWellInterventionAndWorkover.tkrsMain');
    } 
    public function hookWeightSensor()
    {
        return view('DigitalMonitoringWellInterventionAndWorkover.hookWeightSensor');
    } 
    public function hookWeightSensorAnalyse()
    {
        return view('DigitalMonitoringWellInterventionAndWorkover.hookWeightSensorAnalyse');
    }
    public function gps()
    {
        return view('DigitalMonitoringWellInterventionAndWorkover.gps');
    }
    public function videoSurveillance()
    {
        return view('DigitalMonitoringWellInterventionAndWorkover.videoSurveillance');
    }
    public function gpsPositioning()
    {
        return view('DigitalMonitoringWellInterventionAndWorkover.gpsPositioning');
    }  

}
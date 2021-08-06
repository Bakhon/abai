<?php

namespace App\Http\Controllers\DigitalDrilling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:digitalDrilling view main')
            ->only([
                'wellProfile',
                'wellProfileGraph',
                'calculation',
                'calculationGraph',
                'rasters',
                'rastersParams',
                'rastersComponent',
                'deepening',
                'deepeningGraph',
                'deepeningParams',
                'fastening',
                'fasteningPage2',
                'fasteningPage3',
                'fasteningPage4',
                'fasteningPage5',
                'fasteningPage6',
                'fasteningPage7',
            ]);
    }

    public function wellProfile()
    {
        return view('digital_drilling.project.well-profile');
    }

    public function wellProfileGraph()
    {
        return view('digital_drilling.project.well-profile-graph');
    }

    public function calculation()
    {
        return view('digital_drilling.project.calculation');
    }

    public function calculationGraph()
    {
        return view('digital_drilling.project.calculation-graph');
    }

    public function rasters()
    {
        return view('digital_drilling.project.rasters');
    }

    public function rastersParams()
    {
        return view('digital_drilling.project.rasters-params');
    }

    public function rastersComponent()
    {
        return view('digital_drilling.project.rasters-component');
    }

    public function deepening()
    {
        return view('digital_drilling.project.deepening');
    }

    public function deepeningGraph()
    {
        return view('digital_drilling.project.deepening-graph');
    }

    public function deepeningParams()
    {
        return view('digital_drilling.project.deepening-params');
    }

    public function fastening()
    {
        return view('digital_drilling.project.fastening');
    }

    public function fasteningPage2()
    {
        return view('digital_drilling.project.fastening-page2');
    }

    public function fasteningPage3()
    {
        return view('digital_drilling.project.fastening-page3');
    }

    public function fasteningPage4()
    {
        return view('digital_drilling.project.fastening-page4');
    }

    public function fasteningPage5()
    {
        return view('digital_drilling.project.fastening-page5');
    }

    public function fasteningPage6()
    {
        return view('digital_drilling.project.fastening-page6');
    }

    public function fasteningPage7()
    {
        return view('digital_drilling.project.fastening-page7');
    }
}
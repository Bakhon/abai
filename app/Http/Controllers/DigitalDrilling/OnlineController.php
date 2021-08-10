<?php

namespace App\Http\Controllers\DigitalDrilling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnlineController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:digitalDrilling view main')
            ->only([
                'alarm',
                'geoFirst',
                'geoSecond',
                'geoThird',
                'sector',
                'visual',
                'report1',
                'report2',
            ]);
    }

    public function alarm()
    {
        return view('digital_drilling.online.alarm');
    }

    public function geoFirst()
    {
        return view('digital_drilling.online.geo-first');
    }

    public function geoSecond()
    {
        return view('digital_drilling.online.geo-second');
    }

    public function geoThird()
    {
        return view('digital_drilling.online.geo-third');
    }

    public function sector()
    {
        return view('digital_drilling.online.sector');
    }

    public function visual()
    {
        return view('digital_drilling.online.visual');
    }

    public function report1()
    {
        return view('digital_drilling.online.report1');
    }

    public function report2()
    {
        return view('digital_drilling.online.report2');
    }
}

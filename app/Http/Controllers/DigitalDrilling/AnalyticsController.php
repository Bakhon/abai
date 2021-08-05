<?php

namespace App\Http\Controllers\DigitalDrilling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:digitalDrilling view main')
            ->only([
                'deepeningInclino',
                'deepeningVisual',
                'deepeningKnbk',
                'deepeningParams',
                'deepeningBur',
                'deepeningGidro',
                'deepeningSorting',
                'deepeningSelection',
                'fasteningFirst',
                'fasteningSecond',
                'fasteningThird',
                'complications',
                'akc',
                'balance',
            ]);
    }

    public function deepeningInclino()
    {
        return view('digital_drilling.analytics.deepening');
    }

    public function deepeningVisual()
    {
        return view('digital_drilling.analytics.deepening-visual');
    }

    public function deepeningKnbk()
    {
        return view('digital_drilling.analytics.deepening-knbk');
    }

    public function deepeningParams()
    {
        return view('digital_drilling.analytics.deepening-params');
    }

    public function deepeningBur()
    {
        return view('digital_drilling.analytics.deepening-bur');
    }

    public function deepeningGidro()
    {
        return view('digital_drilling.analytics.deepening-gidro');
    }

    public function deepeningSorting()
    {
        return view('digital_drilling.analytics.deepening-sorting');
    }

    public function deepeningSelection()
    {
        return view('digital_drilling.analytics.deepening-selection');
    }

    public function fasteningFirst()
    {
        return view('digital_drilling.analytics.fastening-first');
    }

    public function fasteningSecond()
    {
        return view('digital_drilling.analytics.fastening-second');
    }

    public function fasteningThird()
    {
        return view('digital_drilling.analytics.fastening-third');
    }

    public function complications()
    {
        return view('digital_drilling.analytics.complications');
    }

    public function akc()
    {
        return view('digital_drilling.analytics.akc');
    }

    public function balance()
    {
        return view('digital_drilling.analytics.balance');
    }
}

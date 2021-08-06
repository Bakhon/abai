<?php

namespace App\Http\Controllers\DigitalDrilling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupervisingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:digitalDrilling view main')
            ->only([
                'alarm',
                'reports',
                'balance',
                'balanceSecond',
                'balanceThird',
                'fact',
                'npv',
                'akc',
            ]);
    }

    public function alarm()
    {
        return view('digital_drilling.online.alarm');
    }

    public function reports()
    {
        return view('digital_drilling.supervising.reports');
    }

    public function balance()
    {
        return view('digital_drilling.supervising.balance');
    }

    public function balanceSecond   ()
    {
        return view('digital_drilling.supervising.balance-graph-first');
    }

    public function balanceThird()
    {
        return view('digital_drilling.supervising.balance-graph-second');
    }

    public function fact()
    {
        return view('digital_drilling.supervising.fact');
    }

    public function npv()
    {
        return view('digital_drilling.supervising.npv');
    }

    public function akc()
    {
        return view('digital_drilling.supervising.akc');
    }
}

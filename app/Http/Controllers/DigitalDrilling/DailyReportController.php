<?php

namespace App\Http\Controllers\DigitalDrilling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:digitalDrilling view main')->only([
            'index',
            'raport'
        ]);
    }

    public function index()
    {
        return view('digital_drilling.daily_report.index');
    }
    public function raport()
    {
        return view('digital_drilling.daily_report.import-daily-raport');
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyMeteredOilProductionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function export()
    {
        return Excel::download(new MonthlyMeteredOilProductionExport, 'report.xlsx');
    }

}

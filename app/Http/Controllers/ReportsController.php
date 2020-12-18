<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;

class ReportsController extends Controller
{

    public function index()
    {
        return view('reports.index');
    }

    public function monitoringReport(ReportRequest $request)
    {
        $startDate = \Carbon\Carbon::parse($request->get('start_date'));
        $endDate = \Carbon\Carbon::parse($request->get('end_date'));

        return (new \App\Services\MonitoringReportService())->report($startDate, $endDate);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:monitoring create report');
    }

    public function index()
    {
        return view('reports.index');
    }

    public function generateReport(ReportRequest $request)
    {
        $startDate = \Carbon\Carbon::parse($request->get('start_date'));
        $endDate = \Carbon\Carbon::parse($request->get('end_date'));
        $sections = $request->get('sections');

        $job = new \App\Jobs\ExportMonitoringReportToExcel($startDate, $endDate, $sections);
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }
}

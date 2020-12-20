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

        $job = new \App\Jobs\ExportMonitoringReportToExcel($startDate, $endDate);
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }
}

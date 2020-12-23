<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class MonitoringReportExport implements FromView
{
    protected $data;
    protected $sections;

    function __construct(array $data, array $sections) {
        $this->data = $data;
        $this->sections = $sections;
    }

    public function view(): View
    {
        return view('exports.monitor_report', [
            'data' => $this->data,
            'sections' => $this->sections
        ]);
    }
}

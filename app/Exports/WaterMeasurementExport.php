<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class WaterMeasurementExport implements FromView
{
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.wm', [
            'data' => $this->data
        ]);
    }
}

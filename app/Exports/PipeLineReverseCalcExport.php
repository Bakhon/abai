<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PipeLineReverseCalcExport implements FromView, ShouldAutoSize
{
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.pipeline_reverse_calc_input', [
            'data' => $this->data
        ]);
    }
}

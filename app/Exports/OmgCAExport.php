<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OmgCAExport implements FromView, ShouldAutoSize
{
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.omgca', [
            'data' => $this->data
        ]);
    }
}

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaegtmGtmFactorAnalysisExport implements FromView
{
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.paegtm_gtm_factor_analysis', [
            'data' => $this->data
        ]);
    }
}

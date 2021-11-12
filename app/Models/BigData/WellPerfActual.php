<?php

namespace App\Models\BigData;

use App\Models\TBDModel;

class WellPerfActual extends TBDModel
{
    protected $casts = [
        'perf_date' => 'date'
    ];

    protected $table = 'prod.well_perf_actual';
}


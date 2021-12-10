<?php

namespace App\Models\BigData;

use App\Models\TBDModel;

class WellPerf extends TBDModel
{
    protected $table = 'prod.well_perf';

    public function intervals()
    {
        return $this->hasMany(WellPerfInterval::class, 'well_perf');
    }
}

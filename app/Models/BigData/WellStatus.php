<?php

namespace App\Models\BigData;

use App\Models\TBDModel;

class WellStatus extends TBDModel
{
    protected $table = 'prod.well_status';

    public function statusType()
    {
        return $this->belongsTo(\App\Models\BigData\Dictionaries\WellStatus::class, 'status', 'id');
    }
}
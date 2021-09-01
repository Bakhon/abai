<?php

namespace App\Models\BigData;

use App\Models\TBDModel;

class GdisCurrent extends TBDModel
{
    protected $table = 'prod.gdis_current';

    protected $casts = [
        'meas_date' => 'date'
    ];

    public function values()
    {
        return $this->hasMany(GdisCurrentValue::class, 'gdis_curr');
    }
}

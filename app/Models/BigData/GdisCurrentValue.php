<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\Metric;
use App\Models\TBDModel;

class GdisCurrentValue extends TBDModel
{
    protected $table = 'prod.gdis_current_value';

    public function metricItem()
    {
        return $this->belongsTo(Metric::class, 'metric');
    }

    public function gdisCurrent()
    {
        return $this->belongsTo(GdisCurrent::class, 'gdis_curr');
    }
}

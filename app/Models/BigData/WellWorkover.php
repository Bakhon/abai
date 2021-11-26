<?php

namespace App\Models\BigData;

use App\Models\TBDModel;
use App\Models\BigData\Dictionaries\WellRepairType;

class WellWorkover extends TBDModel
{
    protected $table = 'prod.well_workover';

    public function repairType()
    {
        return $this->hasOne(WellRepairType::class, 'id', 'repair_type');
    }
}

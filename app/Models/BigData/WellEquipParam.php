<?php

namespace App\Models\BigData;

use App\Models\TBDModel;

class WellEquipParam extends TBDModel
{
    protected $table = 'prod.well_equip_param';
    protected $guarded = ['id'];    

    
    public function equipParamItem()
    {
        return $this->belongsTo(Metric::class, 'metric');
    }

    public function wellequip()
    {
        return $this->belongsTo(WellEquip::class, 'well_equip');
    }
}
<?php

namespace App\Models\BigData;

use Illuminate\Database\Eloquent\Model;

class WellEquip extends TBDModel
{
    protected $table = 'prod.well_equip';

    public function values()
    {
        return $this->hasMany(WellEquipParam::class, 'well_equip');
    }
}

<?php

namespace App\Models\BigData\Dictionaries;

use Illuminate\Database\Eloquent\Model;

class EquipParam extends Model
{
    protected $table = 'dict.equip_param';

    protected $casts = [
        'dbeg' => 'date'
    ];
}

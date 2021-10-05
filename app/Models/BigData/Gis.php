<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\GisMethodType;
use App\Models\TBDModel;

class Gis extends TBDModel
{
    protected $table = 'prod.gis';

    public function methods()
    {
        return $this->belongsToMany(GisMethodType::class, 'prod.gis_method_link', 'gis', 'method');
    }
}

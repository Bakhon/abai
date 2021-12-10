<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\GisKind;
use App\Models\BigData\Dictionaries\GisMethodType;
use App\Models\BigData\Dictionaries\GisType;
use App\Models\TBDModel;

class Gis extends TBDModel
{
    protected $table = 'prod.gis';

    public function methods()
    {
        return $this->belongsToMany(GisMethodType::class, 'prod.gis_method_link', 'gis', 'method')
            ->where('code', '!=', 'GATR');
    }

    public function kinds()
    {
        $gisType = GisType::where('code', 'WLS')->first();
        return $this->belongsToMany(GisKind::class, 'prod.gis_kind_link', 'gis', 'kind')
            ->where('gis_type', $gisType->id);
    }
}

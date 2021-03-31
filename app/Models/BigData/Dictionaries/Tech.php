<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;

class Tech extends TBDModel
{
    protected $table = 'dict.tech';

    const TYPE_ZU = 1;
    const TYPE_GU = 3;
    const TYPE_GZU = 2;

    public function parent()
    {
        return $this->belongsTo(Geo::class, 'parent_id', 'id');
    }

    public function wells()
    {
        return $this->belongsToMany(\App\Models\BigData\Well::class, 'prod.well_tech', 'tech', 'well');
    }

    public function type()
    {
        return $this->hasOne(TechType::class, 'tech_type');
    }
}

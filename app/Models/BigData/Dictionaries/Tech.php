<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;

class Tech extends TBDModel
{
    protected $table = 'tbdi.tech';

    public function parent()
    {
        return $this->belongsTo(Geo::class, 'parent_id', 'id');
    }

    public function wells()
    {
        return $this->belongsToMany(\App\Models\BigData\Well::class, 'tbdi.well_tech', 'tech_id', 'well_id');
    }

    public function type()
    {
        return $this->belongsTo(TechType::class, 'tech_id');
    }
}

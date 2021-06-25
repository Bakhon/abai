<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;
use App\Models\BigData\Well;

class GeoMapping extends TBDModel
{
    protected $table = 'dict.well_mapping';
    protected $guarded = ['id'];
    protected $fillable = ['name_ru', 'well_id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function geo()
    {
        return $this->belongsTo(Geo::class, 'well_id', 'id');
    }
}

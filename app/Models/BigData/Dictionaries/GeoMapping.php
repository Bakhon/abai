<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;
use App\Models\BigData\Well;

class GeoMapping extends TBDModel
{
    protected $table = 'dict.geo_mapping';
    protected $guarded = ['id'];
    protected $fillable = ['name_ru', 'geo_id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function geo()
    {
        return $this->belongsTo(Geo::class, 'geo_id', 'id');
    }
}

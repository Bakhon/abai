<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;
use App\Models\BigData\Well;

class WellMapping extends TBDModel
{
    protected $table = 'dict.field_mapping';
    protected $guarded = ['id'];
    protected $fillable = ['name_ru', 'field_id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function well()
    {
        return $this->belongsTo(Well::class, 'well_id', 'id');
    }
}

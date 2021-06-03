<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;

class StemType extends TBDModel
{
    protected $table = 'dict.stem_type';
    protected $guarded = ['id'];
    protected $fillable = ['name_ru'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}

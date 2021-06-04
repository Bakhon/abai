<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;

class RecordingMethod extends TBDModel
{
    protected $table = 'dict.recording_method';
    protected $guarded = ['id'];
    protected $fillable = ['name_ru'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}

<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;

class RecordingState extends TBDModel
{
    protected $table = 'dict.recording_state';
    protected $guarded = ['id'];
    protected $fillable = ['name_ru'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}

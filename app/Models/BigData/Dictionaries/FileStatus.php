<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;

class FileStatus extends TBDModel
{
    protected $table = 'dict.file_status';
    protected $guarded = ['id'];
    protected $fillable = ['name_ru'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}

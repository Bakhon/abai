<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTemplate extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'string',
        'headers' => 'string',
        'selected_objects' => 'string',
    ];
}

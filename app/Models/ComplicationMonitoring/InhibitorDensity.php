<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class InhibitorDensity extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
    ];
}

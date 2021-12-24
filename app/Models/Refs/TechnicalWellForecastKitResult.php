<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalWellForecastKitResult extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'enabled_uwis' => 'array',
        'stopped_uwis' => 'array',
    ];
}

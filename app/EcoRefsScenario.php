<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcoRefsScenario extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'oil_prices' => 'array',
        'course_prices' => 'array',
        'optimizations' => 'array',
    ];
}

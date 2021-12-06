<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class EcoRefsScenarioResult extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'variants' => 'array',
        'wells' => 'array',
    ];
}

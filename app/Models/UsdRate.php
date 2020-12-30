<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsdRate extends Model
{
    protected $table = 'usd_rate';

    protected $guarded = ['id'];

    protected $casts = [
        'value' => 'string',
        'date' => 'date',
        'change' => 'string',
        'index' => 'string',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OilDaily extends Model
{
    protected $table = 'oil_daily';

    protected $fillable = [
        'liquid', 'date'
    ];
}

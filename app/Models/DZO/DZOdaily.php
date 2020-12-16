<?php

namespace App\Models\DZO;

use Illuminate\Database\Eloquent\Model;

class DZOdaily extends Model
{
    protected $table = 'd_z_odailies';

    protected $fillable = [
        'a',
        'b',
        'c'
    ];
}

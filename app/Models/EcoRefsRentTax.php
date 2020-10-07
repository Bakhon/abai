<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsRentTax extends Model
{

    protected $fillable = [
        'world_price_beg', 'world_price_end', 'rate'
    ];

}

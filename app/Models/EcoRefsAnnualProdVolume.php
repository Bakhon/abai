<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsAnnualProdVolume extends Model
{
    protected $fillable = [
        'annual_prod_volume_beg', 'annual_prod_volume_end', 'ndpi'
    ];
}

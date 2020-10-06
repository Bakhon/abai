<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsAvgMarketPrice extends Model
{

    protected $fillable = [
        'avg_market_price_beg', 'avg_market_price_end', 'exp_cust_duty_rate'
    ];
}

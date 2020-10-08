<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsAvgMarketPrice extends Model
{

    protected $fillable = [
        'sc_fa', 'avg_market_price_beg', 'avg_market_price_end', 'exp_cust_duty_rate'
    ];
    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa','id','sc_fa')->withDefault();
    }
}

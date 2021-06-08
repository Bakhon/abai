<?php

namespace App\Models;

use App\Models\Refs\EcoRefsScFa;
use Illuminate\Database\Eloquent\Model;

class EcoRefsAvgMarketPrice extends Model
{

    protected $fillable = [
        'sc_fa', 'avg_market_price_beg', 'avg_market_price_end', 'exp_cust_duty_rate'
    ];
    public function scfa()
    {
        return $this->hasOne(EcoRefsScFa::class,'id','sc_fa')->withDefault();
    }
}

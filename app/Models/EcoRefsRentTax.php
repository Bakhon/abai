<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsRentTax extends Model
{

    protected $fillable = [
        'sc_fa', 'world_price_beg', 'world_price_end', 'rate'
    ];
    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa','id','sc_fa')->withDefault();
    }
}

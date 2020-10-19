<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsAnnualProdVolume extends Model
{
    protected $fillable = [
        'sc_fa', 'annual_prod_volume_beg', 'annual_prod_volume_end', 'ndpi'
    ];
    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa','id','sc_fa')->withDefault();
    }
}

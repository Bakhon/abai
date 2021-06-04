<?php

namespace App\Models;

use App\Models\Refs\EcoRefsScFa;
use Illuminate\Database\Eloquent\Model;

class EcoRefsAnnualProdVolume extends Model
{
    protected $fillable = [
        'sc_fa', 'annual_prod_volume_beg', 'annual_prod_volume_end', 'ndpi'
    ];
    public function scfa()
    {
        return $this->hasOne(EcoRefsScFa::class,'id','sc_fa')->withDefault();
    }
}

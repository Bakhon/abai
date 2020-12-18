<?php

namespace App\Models\VizCenter;

use Illuminate\Database\Eloquent\Model;

class Marab2 extends Model
{
    protected $fillable = [
        'company_id',
        'type_id',
        'date',
        'dividends',
        'vklad_v_ustavnoy_kapital',
        'vydacha_zaimov',
        'vozvrat_zaimov',
        'vozvrat_ustavnogo_kapitala',
        'others'
    ];
    
    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
    public function type()
    {
        return $this->hasOne('App\Models\VizCenter\TypeId','id','type_id')->withDefault();
    }
}

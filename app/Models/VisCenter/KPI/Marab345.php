<?php

namespace App\Models\VisCenter\KPI;

use Illuminate\Database\Eloquent\Model;

class Marab345 extends Model
{
    protected $fillable = [
        'company_id',
        'marabkpi_id',
        'type_id',
        'date',
        // '__time',
        'fact_zatraty_na_sebestoimost_dobychi_nefti',
        'fact_zatraty_kapitalnogo_vlozhenia',
        'opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov'
    ];
    
    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
    public function type()
    {
        return $this->hasOne('App\Models\VisCenter\KPI\TypeId','id','type_id')->withDefault();
    }
    public function marabkpi()
    {
        return $this->hasOne('App\Models\VisCenter\KPI\MarabKpiId','id','marabkpi_id')->withDefault();
    }
}

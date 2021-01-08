<?php

namespace App\Models\VisCenter\KPI;

use Illuminate\Database\Eloquent\Model;

class CorpAll extends Model
{
    protected $fillable = [
        'company_id',
        'type_id',
        'corpkpi_id',
        'date',
        'value',
    ];
    
    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
    public function corpkpi()
    {
        return $this->hasOne('App\Models\VisCenter\KPI\CorpKpiId','id','corpkpi_id')->withDefault();
    }
    public function type()
    {
        return $this->hasOne('App\Models\VisCenter\KPI\TypeId','id','type_id')->withDefault();
    }
}

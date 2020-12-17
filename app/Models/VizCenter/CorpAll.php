<?php

namespace App\Models\VizCenter;

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
        return $this->hasOne('App\Models\VizCenter\CorpKpiId','id','corpkpi_id')->withDefault();
    }
    public function type()
    {
        return $this->hasOne('App\Models\VizCenter\TypeId','id','type_id')->withDefault();
    }
}

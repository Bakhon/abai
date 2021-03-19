<?php

namespace App\Models\VisCenter\KPI;

use Illuminate\Database\Eloquent\Model;

class Marab1 extends Model
{
    protected $fillable = [
        'company_id',
        'type_id',
        'date',
        'A_category',
        'B_category',
        'C1_category'
    ];
    
    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
    public function type()
    {
        return $this->hasOne('App\Models\VisCenter\KPI\TypeId','id','type_id')->withDefault();
    }
}

<?php

namespace App\Models\EconomyKenzhe;

use App\Models\EcoRefsDiscontCoefBar;
use Illuminate\Database\Eloquent\Model;

class CompanyRealizationPercent extends Model
{
    protected $table = 'eco_refs_emp_pers';

    protected $fillable = [
        'sc_fa', 'company_id', 'direction_id', 'route_id', 'date', 'emp_per'
    ];

    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa','id','sc_fa')->withDefault();
    }

    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
    public function direction()
    {
        return $this->hasOne('App\Models\EcoRefsDirectionId','id','direction_id')->withDefault();
    }
    public function route()
    {
        return $this->hasOne('App\Models\EcoRefsRoutesId','id','route_id')->withDefault();
    }

    public function getCompanyDiscontСoefficientBarrel()
    {
        return $this->belongsTo(EcoRefsDiscontCoefBar::class, 'route_id', 'id');
    }
}

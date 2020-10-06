<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsDiscontCoefBar extends Model
{

    protected $fillable = [
        'company_id', 'direction_id', 'route_id', 'date', 'barr_coef', 'discont', 'oil_cost', 'macro'
    ];

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
}

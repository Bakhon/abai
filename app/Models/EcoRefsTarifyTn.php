<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsTarifyTn extends Model
{
    protected $fillable = [
        'sc_fa', 'branch_id', 'company_id', 'direction_id', 'route_id', 'route_tn_id', 'exc_id', 'date', 'tn_rate'
    ];

    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa', 'id', 'sc_fa')->withDefault();
    }

    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId', 'id', 'company_id')->withDefault();
    }

    public function branch()
    {
        return $this->hasOne('App\Models\EcoRefsBranchId','id','branch_id')->withDefault();
    }

    public function direction()
    {
        return $this->hasOne('App\Models\EcoRefsDirectionId','id','direction_id')->withDefault();
    }
    public function route()
    {
        return $this->hasOne('App\Models\EcoRefsRoutesId','id','route_id')->withDefault();
    }
    public function routetn()
    {
        return $this->hasOne('App\Models\EcoRefsRouteTnId','id','route_tn_id')->withDefault();
    }
    public function exc()
    {
        return $this->hasOne('App\Models\EcoRefsExc','id','exc_id')->withDefault();
    }

}

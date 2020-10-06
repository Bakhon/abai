<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsTarifyTn extends Model
{
    protected $fillable = [
        'branch_id', 'company_id', 'direction_id', 'route_tn_id', 'date', 'tn_rate', 'extent'
    ];

    public function branch()
    {
        return $this->hasOne('App\Models\EcoRefsBranchId','id','branch_id')->withDefault();
    }
   public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
    public function direction()
    {
        return $this->hasOne('App\Models\EcoRefsDirectionId','id','direction_id')->withDefault();
    }
    public function routetn()
    {
        return $this->hasOne('App\Models\EcoRefsRouteTnId','id','route_tn_id')->withDefault();
    }
}

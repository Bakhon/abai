<?php

namespace App\Models;

use App\Models\Refs\EcoRefsScFa;
use Illuminate\Database\Eloquent\Model;

class EcoRefsTarifyTn extends Model
{
    protected $fillable = [
        'sc_fa', 'branch_id', 'company_id', 'direction_id', 'route_id', 'route_tn_id', 'exc_id', 'date', 'tn_rate'
    ];

    public function scfa()
    {
        return $this->hasOne(EcoRefsScFa::class,'id','sc_fa')->withDefault();
    }
    public function branch()
    {
        return $this->hasOne(EcoRefsBranchId::class,'id','branch_id')->withDefault();
    }
   public function company()
    {
        return $this->hasOne(EcoRefsCompaniesId::class,'id','company_id')->withDefault();
    }
    public function direction()
    {
        return $this->hasOne(EcoRefsDirectionId::class,'id','direction_id')->withDefault();
    }
    public function route()
    {
        return $this->hasOne(EcoRefsRoutesId::class,'id','route_id')->withDefault();
    }
    public function routetn()
    {
        return $this->hasOne(EcoRefsRouteTnId::class,'id','route_tn_id')->withDefault();
    }
    public function exc()
    {
        return $this->hasOne(EcoRefsExc::class,'id','exc_id')->withDefault();
    }

}

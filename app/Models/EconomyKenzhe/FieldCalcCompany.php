<?php

namespace App\Models\EconomyKenzhe;

use App\Models\EcoRefsDiscontCoefBar;
use App\Models\EcoRefsRoute;
use App\Models\Refs\EcoRefsEmpPer;
use Illuminate\Database\Eloquent\Model;

class FieldCalcCompany extends Model
{
    protected $table = 'eco_refs_companies_ids';

    public function getCompanyBarrelPriceByDirection($direction)
    {
//        return $this->hasMany(EcoRefsEmpPer::class, 'sc_fa', 'id')->with('scfa')->whereYear('date','=','2021')->whereDirectionId($direction);
//        return $this->hasMany(EcoRefsEmpPer::class, 'company_id', 'id')->where('sc_fa', '=', 2)->with('scfa')->whereYear('date','=','2021')->whereDirectionId($direction);
        return $this->hasMany(EcoRefsEmpPer::class, 'company_id', 'id')->where('sc_fa', '=', 2)->with('scfa')->whereYear('date','=','2021')->whereDirectionId($direction);
    }

    public function routes()
    {
        return $this->belongsTo(EcoRefsRoute::class, 'route_id', 'id');
    }

    public function getCompanyDiscontСoefficientBarrel()
    {
        return $this->belongsTo(EcoRefsDiscontCoefBar::class, 'route_id', 'id');
    }


}
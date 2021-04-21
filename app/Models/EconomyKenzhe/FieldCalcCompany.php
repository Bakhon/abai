<?php

namespace App\Models\EconomyKenzhe;

use App\Models\EcoRefsDiscontCoefBar;
use App\Models\EcoRefsRoute;
use Illuminate\Database\Eloquent\Model;

class FieldCalcCompany extends Model
{
    protected $table = 'eco_refs_companies_ids';

    public function getCompanyBarrelPriceByDirection($direction)
    {
        return $this->hasMany(CompanyRealizationPercent::class, 'company_id', 'id')->where('sc_fa', '=', 2)->with(['scfa', 'getCompanyDiscontСoefficientBarrel','direction'])->whereYear('date','=','2021')->whereDirectionId($direction);
    }

    public function routes()
    {
        return $this->belongsTo(EcoRefsRoute::class, 'route_id', 'id');
    }
}
<?php

namespace App\Models\EconomyKenzhe;

use App\Models\EcoRefsAvgPrs;
use App\Models\EcoRefsPrepElectPrsBrigCost;
use App\Models\EcoRefsRoute;
use Illuminate\Database\Eloquent\Model;

class FieldCalcCompany extends Model
{
    protected $table = 'eco_refs_companies_ids';

    public function getCompanyBarrelPriceByDirection($direction, $scenario_fact)
    {
        return $this->hasMany(CompanyRealizationPercent::class, 'company_id', 'id')->where('sc_fa', '=', $scenario_fact)->with(['scfa', 'getCompanyDiscontСoefficientBarrel','direction', 'route'])->whereYear('date','=','2021')->whereDirectionId($direction);
    }

    public function routes()
    {
        return $this->belongsTo(EcoRefsRoute::class, 'route_id', 'id');
    }

    //Стоимость электроэнергии, тенге/кВт*ч
    //Стоимость транспортировки и подготовки, тенге/тонна:
    //Стоимость 1 сутки бригады ПРС, тенге:
    public function compRas($scenario_fact)
    {
        return $this->hasMany(EcoRefsPrepElectPrsBrigCost::class, 'company_id', 'id')->where('sc_fa', '=', $scenario_fact);
    }

    public function averagePrs(){
        return $this->hasMany(EcoRefsAvgPrs::class, 'company_id', 'id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsPrepElectPrsBrigCost extends Model
{
    protected $fillable = [
        'company_id', 'date', 'elect_cost', 'trans_prep_cost', 'prs_brigade_cost'
    ];

    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
}

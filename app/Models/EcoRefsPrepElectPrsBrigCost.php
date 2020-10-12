<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsPrepElectPrsBrigCost extends Model
{
    protected $fillable = [
        'sc_fa', 'company_id', 'date', 'elect_cost', 'trans_prep_cost', 'prs_brigade_cost'
    ];

    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa','id','sc_fa')->withDefault();
    }
    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
}

<?php

namespace App\Models\AntiRefs;

use Illuminate\Database\Eloquent\Model;

class AntiEcoTwo extends Model
{
    protected $fillable = [
        'sc_fa', 'company_id', 'oil_cost', 'oil_cost_exp_one', 'oil_cost_exp_two', 'oil_cost_exp_three', 'oil_cost_ins_one', 'oil_cost_ins_two'
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

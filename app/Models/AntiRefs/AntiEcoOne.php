<?php

namespace App\Models\AntiRefs;

use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Database\Eloquent\Model;

class AntiEcoOne extends Model
{
    protected $fillable = [
        'sc_fa', 'company_id', 'dbeg', 'dend', 'bar_coef_exp_one', 'bar_coef_exp_two', 'bar_coef_exp_three', 'bar_coef_ins_one', 'bar_coef_ins_two',
        'sales_share_exp_one', 'sales_share_exp_two', 'sales_share_exp_three', 'sales_share_ins_one', 'sales_share_ins_two', 'disc_exp_one',
        'disc_exp_two', 'disc_exp_three', 'disc_ins_one', 'disc_ins_two', 'trans_exp_cost_one', 'trans_exp_cost_two', 'trans_exp_cost_three', 'trans_ins_cost_one',
        'trans_ins_cost_two', 'var_cost_one', 'var_cost_two', 'fix_cost_one', 'fix_cost_two', 'fix_cost_three', 'fix_cost_four', 'adm_exp', 'avg_prs_cost',
        'fot_prs', 'avg_prs_cost_fot', 'avg_krs_cost', 'amort'
    ];

    public function scfa()
    {
        return $this->hasOne(EcoRefsScFa::class,'id','sc_fa')->withDefault();
    }

    public function company()
    {
        return $this->hasOne(EcoRefsCompaniesId::class,'id','company_id')->withDefault();
    }
}

<?php

namespace App\Models\DZO;

use Illuminate\Database\Eloquent\Model;

class DZOcalc extends Model
{
    protected $table = 'd_z_ocalcs';

    protected $fillable = [
        'dzo',
        'date',
        '__time',
        'main_prc_val_plan',
        'spending_val_plan',
        'cost_val_plan',
        'rlz_spending_val_plan',
        'adm_spending_val_plan',
        'net_profit_val_plan',
        'editba_val_plan',
        'editba_margin_val_plan',
        'capital_inv_val_plan',
        'cash_flow_val_plan',
        'ud_income_val_plan',
        'ud_income_bbl_val_plan',
        'ud_spending_val_plan',
        'ud_spending_bbl_val_plan',
        'kvl_val_plan',
        'oil_val_plan',
        'main_prc_val_fact',
        'spending_val_fact',
        'cost_val_fact',
        'rlz_spending_val_fact',
        'adm_spending_val_fact',
        'net_profit_val_fact',
        'editba_val_fact',
        'editba_margin_val_fact',
        'capital_inv_val_fact',
        'cash_flow_val_fact',
        'ud_income_val_fact',
        'ud_income_bbl_val_fact',
        'ud_spending_val_fact',
        'ud_spending_bbl_val_fact',
        'kvl_val_fact',
        'oil_val_fact',
        'main_prc_plan_2020',
        'spending_plan_2020',
        'cost_plan_2020',
        'rlz_spending_plan_2020',
        'adm_spending_plan_2020',
        'net_profit_plan_2020',
        'editba_plan_2020',
        'editba_margin_plan_2020',
        'capital_inv_plan_2020',
        'cash_flow_plan_2020',
        'ud_income_plan_2020',
        'ud_income_bbl_plan_2020',
        'ud_spending_plan_2020',
        'ud_spending_bbl_plan_2020',
        'kvl_plan_2020',
        'oil_plan_2020'
    ];
}

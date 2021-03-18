<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dzoPlan extends Model
{
    protected $table = 'dzo_plans';

    protected $fillable = [
        "date",
        "dzo",
        "plan_oil",
        "plan_kondensat",
        "plan_oil_dlv",
        "plan_kondensat_dlv",
        "plan_liq",
        "plan_par",
        "plan_gas",
        "plan_gas_dlv",
        "plan_otm_iz_burenia_skv",
        "plan_otm_burenie_prohodka",
        "plan_otm_krs_skv_plan",
        "plan_otm_prs_skv_plan",
        "plan_chem_prod_zakacka_demulg",
        "plan_chem_prod_zakacka_bakteracid",
        "plan_chem_prod_zakacka_ingibator_korrozin",
        "plan_chem_prod_zakacka_ingibator_soleotloj"

    ];
}

<?php

namespace App\Models\Paegtm;

use App\Models\TBDModel;

class DzoAegtm extends TBDModel
{
    protected $table = 'paegtm.dzo_aegtm';

    protected $fillable = [
        'org_name',
        'org_name_short',
        'date',
        'oil_prod_plan',
        'oil_prod_fact',
        'base_oil_prod_plan',
        'base_oil_prod_fact',
        'gtm_oil_prod_plan',
        'gtm_oil_prod_fact',
        'vns_plan_total',
        'vns_fact_total',
        'vns_prod_plan_total',
        'vns_prod_fact_total',
        'vns_plan',
        'vns_fact',
        'vns_prod_plan',
        'vns_prod_fact',
        'vns_grp_plan',
        'vns_grp_fact',
        'vns_grp_prod_plan',
        'vns_grp_prod_fact',
        'gs_plan',
        'gs_fact',
        'gs_prod_plan',
        'gs_prod_fact',
        'zbs_plan',
        'zbs_fact',
        'zbs_prod_plan',
        'zbs_prod_fact',
        'zbgs_plan',
        'zbgs_fact',
        'zbgs_prod_plan',
        'zbgs_prod_fact',
        'grp_plan',
        'grp_fact',
        'grp_prod_plan',
        'grp_prod_fact',
        'pvlg_plan',
        'pvlg_fact',
        'pvlg_prod_plan',
        'pvlg_prod_fact',
        'pvr_plan',
        'pvr_fact',
        'pvr_prod_plan',
        'prv_prod_fact',
        'vns_prod_plan_chart',
        'vns_prod_fact_chart',
        'vns_plan_chart',
        'vns_fact_chart',
        'gtm_prod_plan_chart',
        'gtm_prod_fact_chart',
        'gtm_plan_chart',
        'gtm_fact_chart',
    ];
}
<?php

namespace App\Models\VisCenter\ImportForms;

use Illuminate\Database\Eloquent\Model;

class DZOday extends Model
{
    protected $table = 'd_z_odays';

    protected $fillable = [
        'date',
        'dzo',
        'mestorozhdenie',
        'ngdu',
        'oil_plan',
        'oil_fact',
        'gk_plan',
        'gk_fact',
        'dobycha_zhidkosti_plan',
        'dobycha_zhidkosti_fact',
        'sdacha_nefti_kuun',
        'oil_dlv_plan',
        'oil_dlv_fact',
        'tovarnyi_ostatok_nefti_prev_day',
        'tovarnyi_ostatok_nefti_today',
        'dobycha_gaza_prirod_plan',
        'dobycha_gaza_prirod_fact',
        'sdacha_gaza_prirod_plan',
        'sdacha_gaza_prirod_fact',
        'raskhod_prirod_plan',
        'raskhod_prirod_fact',
        'pererabotka_gaza_prirod_plan',
        'pererabotka_gaza_prirod_fact',
        'dobycha_gaza_poput_plan',
        'dobycha_gaza_poput_fact',
        'sdacha_gaza_poput_plan',
        'sdacha_gaza_poput_fact',
        'raskhod_poput_plan',
        'raskhod_poput_fact',
        'raskhod_syraya_poput_plan',
        'raskhod_syraya_poput_fact',
        'raskhod_syraya_tovarnaya_plan',
        'raskhod_tovarnaya_poput_fact',
        'pererabotka_gaza_poput_plan',
        'pererabotka_gaza_poput_fact',
        'poput_tech_poteri',
        'poput_razresheno_sjiganie',
        'ppd_zakachka_morskoi_vody_plan',
        'ppd_zakachka_morskoi_vody_fact',
        'ppd_zakachka_stochnoi_vody_plan',
        'ppd_zakachka_stochnoi_vody_fact',
        'ppd_zakachka_albsen_vody_plan',
        'ppd_zakachka_albsen_vody_fact',
        'ppd_zakachka_gaza_plan',
        'ppd_zakachka_gaza_fact',
        'ppd_zakachka_plast_poput_vody_plan',
        'ppd_zakachka_plast_poput_vody_fact',
        'ppd_zakachka_plast_apsk_vody_plan',
        'ppd_zakachka_plast_apsk_vody_fact',
        'ppd_zakachka_voljskoy_vody_plan',
        'ppd_zakachka_voljskoy_vody_fact',
        'ppd_zakachka_senopal_vody_plan',
        'ppd_zakachka_senopal_vody_fact',
        'otm_iz_burenia_skv_plan',
        'otm_iz_burenia_skv_fact',
        'otm_burenie_prohodka_plan',
        'otm_burenie_prohodka_fact',
        'otm_krs_skv_plan',
        'otm_krs_skv_fact',
        'otm_prs_skv_plan',
        'otm_prs_skv_fact',
        'cpp_zakachka_para_plan',
        'cpp_zakachka_para_fact',
        'fond_neftedob_ef',
        'fond_neftedob_df',
        'prod_wells_work',
        'fond_neftedob_prs',
        'fond_neftedob_oprs',
        'fond_neftedob_krs',
        'fond_neftedob_okrs',
        'fond_neftedob_well_survey',
        'fond_neftedob_others',
        'fond_neftedob_bd',
        'fond_neftedob_osvoenie',
        'fond_neftedob_ofls',
        'fond_neftedob_nrs',
        'fond_neftedob_prostoy',
        'fond_neftedob_prostoy_el',
        'fond_neftedob_svabirovanie',
        'fond_neftedob_period',
        'fond_neftedob_vysokoobvod',
        'fond_nagnetat_ef',
        'fond_nagnetat_df',
        'inj_wells_work',
        'fond_nagnetat_prs',
        'fond_nagnetat_oprs',
        'fond_nagnetat_krs',
        'fond_nagnetat_okrs',
        'fond_nagnetat_well_survey',
        'fond_nagnetat_others',
        'fond_nagnetat_bd',
        'fond_nagnetat_osvoenie',
        'fond_nagnetat_ofls',
        'fond_nagnetat_konv',
        'fond_nagnetat_ostanovka',
        'fond_nagnetat_neftedob_fls',
        'fond_nagnetat_neftedob_konserv',
        'chem_prod_zakacka_demulg_amount',
        'chem_prod_zakacka_demulg_plan',
        'chem_prod_zakacka_demulg_fact',
        'chem_prod_zakacka_bakteracid_amount',
        'chem_prod_zakacka_bakteracid_plan',
        'chem_prod_zakacka_bakteracid_fact',
        'chem_prod_zakacka_ingibator_korrozin_amount',
        'chem_prod_zakacka_ingibator_korrozin_plan',
        'chem_prod_zakacka_ingibator_korrozin_fact',
        'chem_prod_zakacka_ingibator_soleotloj_amount',
        'chem_prod_zakacka_ingibator_soleotloj_plan',
        'chem_prod_zakacka_ingibator_soleotloj_fact',
        'tb_personal_plan',
        'tb_personal_fact',
        'tb_accident_total',
        'tb_accident_death',
        'tb_covid_prev_day',
        'tb_covid_total',
        'tb_covid_recover',
        "__time",
        "gas_plan",
        "gas_fact",
        "liq_plan",
        "liq_fact",
        "inj_wells_idle",
        "prod_wells_idle",
    ];
}

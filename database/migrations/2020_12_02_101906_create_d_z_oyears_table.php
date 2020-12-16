<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDZOyearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_z_oyears', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer("date");
            $table->text("dzo");
            $table->text("mestorozhdenie")->nullable();	
            $table->text("ngdu")->nullable();
            
            $table->float("oil_plan",32,8)->nullable();
            $table->float("oil_fact",32,8)->nullable();
            $table->float("gk_plan",32,8)->nullable();	
            $table->float("gk_fact",32,8)->nullable();	
            $table->float("liq_plan",32,8)->nullable();
            $table->float("liq_fact",32,8)->nullable();
            $table->float("sdacha_nefti_kuun",32,8)->nullable();						
            $table->float("oil_dlv_plan",32,8)->nullable(); 
            $table->float("oil_dlv_fact",32,8)->nullable();
            $table->float("tovarnyi_ostatok_nefti",32,8)->nullable(); 
            
            $table->float("dobycha_gaza_prirod_plan",32,8)->nullable();
            $table->float("dobycha_gaza_prirod_fact",32,8)->nullable();	
            $table->float("sdacha_gaza_prirod_plan",32,8)->nullable();	
            $table->float("sdacha_gaza_prirod_fact",32,8)->nullable();
            $table->float("raskhod_prirod_plan",64,8)->nullable();
            $table->float("raskhod_prirod_fact",32,8)->nullable();						
            $table->float("pererabotka_gaza_prirod_plan",32,8)->nullable(); 
            $table->float("pererabotka_gaza_prirod_fact",32,8)->nullable();

            $table->float("dobycha_gaza_poput_plan",32,8)->nullable();
            $table->float("dobycha_gaza_poput_fact",32,8)->nullable(); 
            $table->float("sdacha_gaza_poput_plan",32,8)->nullable();
            $table->float("sdacha_gaza_poput_fact",32,8)->nullable();
            $table->float("raskhod_poput_plan",32,8)->nullable();
            $table->float("raskhod_poput_fact",32,8)->nullable();
            $table->float("raskhod_syraya_poput_plan",32,8)->nullable();
            $table->float("raskhod_syraya_poput_fact",32,8)->nullable();
            $table->float("raskhod_syraya_tovarnaya_plan",32,8)->nullable(); 
            $table->float("raskhod_tovarnaya_poput_fact",32,8)->nullable();
            $table->float("pererabotka_gaza_poput_plan",32,8)->nullable();
            $table->float("pererabotka_gaza_poput_fact",32,8)->nullable();
            $table->float("poput_tech_poteri",32,8)->nullable()->nullable();
            $table->float("poput_razresheno_sjiganie",32,8)->nullable();

            $table->float("ppd_zakachka_morskoi_vody_plan",32,8)->nullable();
            $table->float("ppd_zakachka_morskoi_vody_fact",32,8)->nullable();
            $table->float("ppd_zakachka_stochnoi_vody_plan",32,8)->nullable();
            $table->float("ppd_zakachka_stochnoi_vody_fact",32,8)->nullable();
            $table->float("ppd_zakachka_albsen_vody_plan",32,8)->nullable();
            $table->float("ppd_zakachka_albsen_vody_fact",32,8)->nullable();
            $table->float("ppd_zakachka_gaza_plan",32,8)->nullable();
            $table->float("ppd_zakachka_gaza_fact",32,8)->nullable();
            $table->float("ppd_zakachka_plast_poput_vody_plan",32,8)->nullable();
            $table->float("ppd_zakachka_plast_poput_vody_fact",32,8)->nullable();
            $table->float("ppd_zakachka_plast_apsk_vody_plan",32,8)->nullable();
            $table->float("ppd_zakachka_plast_apsk_vody_fact",32,8)->nullable();
            $table->float("ppd_zakachka_voljskoy_vody_plan",32,8)->nullable();
            $table->float("ppd_zakachka_voljskoy_vody_fact",32,8)->nullable();
            $table->float("ppd_zakachka_senopal_vody_plan",32,8)->nullable();
            $table->float("ppd_zakachka_senopal_vody_fact",32,8)->nullable();

            $table->float("otm_iz_burenia_skv_plan",32,8)->nullable();
            $table->float("otm_iz_burenia_skv_fact",32,8)->nullable();
            $table->float("otm_burenie_prohodka_plan",32,8)->nullable();
            $table->float("otm_burenie_prohodka_fact",32,8)->nullable();
            $table->float("otm_krs_skv_plan",32,8)->nullable();
            $table->float("otm_krs_skv_fact",32,8)->nullable();
            $table->float("otm_prs_skv_plan",32,8)->nullable();
            $table->float("otm_prs_skv_fact",32,8)->nullable();

            $table->float("cpp_zakachka_para_plan",32,8)->nullable();
            $table->float("cpp_zakachka_para_fact",32,8)->nullable();

            $table->float("fond_neftedob_ef",32,8)->nullable();
            $table->float("fond_neftedob_df",32,8)->nullable();
            $table->float("prod_wells_work",32,8)->nullable();
            $table->float("fond_neftedob_prs",32,8)->nullable();
            $table->float("fond_neftedob_oprs",32,8)->nullable();
            $table->float("fond_neftedob_krs",32,8)->nullable();
            $table->float("fond_neftedob_okrs",32,8)->nullable();
            $table->float("fond_neftedob_well_survey",32,8)->nullable();
            $table->float("fond_neftedob_others",32,8)->nullable();
            $table->float("fond_neftedob_bd",32,8)->nullable();
            $table->float("fond_neftedob_osvoenie",32,8)->nullable();
            $table->float("fond_neftedob_ofls",32,8)->nullable();
            $table->float("fond_neftedob_nrs",32,8)->nullable();
            $table->float("prod_wells_idle",32,8)->nullable();
            $table->float("fond_neftedob_prostoy_el",32,8)->nullable();
            $table->float("fond_neftedob_svabirovanie",32,8)->nullable();
            $table->float("fond_neftedob_period",32,8)->nullable();
            $table->float("fond_neftedob_vysokoobvod",32,8)->nullable();

            $table->float("fond_nagnetat_ef",32,8)->nullable();
            $table->float("fond_nagnetat_df",32,8)->nullable();
            $table->float("inj_wells_work",32,8)->nullable();
            $table->float("fond_nagnetat_prs",32,8)->nullable();
            $table->float("fond_nagnetat_oprs",32,8)->nullable();
            $table->float("fond_nagnetat_krs",32,8)->nullable();
            $table->float("fond_nagnetat_okrs",32,8)->nullable();
            $table->float("fond_nagnetat_well_survey",32,8)->nullable();
            $table->float("fond_nagnetat_others",32,8)->nullable();
            $table->float("fond_nagnetat_bd",32,8)->nullable();
            $table->float("fond_nagnetat_osvoenie",32,8)->nullable();
            $table->float("fond_nagnetat_ofls",32,8)->nullable();
            $table->float("fond_nagnetat_konv",32,8)->nullable();
            $table->float("fond_nagnetat_ostanovka",32,8)->nullable();

            $table->float("fond_nagnetat_neftedob_fls",32,8)->nullable();
            $table->float("fond_nagnetat_neftedob_konserv",32,8)->nullable();

            $table->integer("chem_prod_zakacka_demulg_amount")->nullable();
            $table->float("chem_prod_zakacka_demulg_plan",32,8)->nullable();
            $table->float("chem_prod_zakacka_demulg_fact",32,8)->nullable();
            $table->integer("chem_prod_zakacka_bakteracid_amount")->nullable();
            $table->float("chem_prod_zakacka_bakteracid_plan",32,8)->nullable();
            $table->float("chem_prod_zakacka_bakteracid_fact",32,8)->nullable();
            $table->integer("chem_prod_zakacka_ingibator_korrozin_amount")->nullable();
            $table->float("chem_prod_zakacka_ingibator_korrozin_plan",32,8)->nullable();
            $table->float("chem_prod_zakacka_ingibator_korrozin_fact",32,8)->nullable();
            $table->integer("chem_prod_zakacka_ingibator_soleotloj_amount")->nullable();
            $table->float("chem_prod_zakacka_ingibator_soleotloj_plan",32,8)->nullable();
            $table->float("chem_prod_zakacka_ingibator_soleotloj_fact",32,8)->nullable();

            $table->integer("tb_personal_plan")->nullable();
            $table->integer("tb_personal_fact")->nullable();
            $table->integer("tb_accident_total")->nullable();
            $table->integer("tb_accident_death")->nullable();
            $table->integer("tb_covid_prev_day")->nullable();
            $table->integer("tb_covid_total")->nullable();
            $table->integer("tb_covid_recover")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_z_oyears');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDZOdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_z_odays', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->dateTime('date', 0);	
            $table->text("dzo_name")->nullable();
            $table->text("mestorozhdenie")->nullable();	
            $table->text("ngdu")->nullable();
            $table->float("dobycha_nefti_plan",8,4)->nullable();
            $table->float("dobycha_nefti_fact",8,4)->nullable();
            $table->float("dobycha_kondensata_plan",8,4)->nullable();	
            $table->float("dobycha_kondensata_fact",8,4)->nullable();	
            $table->float("dobycha_zhidkosti_plan",8,4)->nullable();
            $table->float("dobycha_zhidkosti_fact",8,4)->nullable();
            $table->float("sdacha_nefti_kuun",8,4)->nullable();						
            $table->float("sdacha_nefti_plan",8,4)->nullable(); 
            $table->float("sdacha_nefti_fact",8,4)->nullable();
            $table->float("tovarnyi_ostatok_nefti_prev_day",8,4)->nullable();
            $table->float("tovarnyi_ostatok_nefti_today",8,4)->nullable(); 
            $table->float("dobycha_gaza_prirod_plan",8,4)->nullable();
            $table->float("dobycha_gaza_prirod_fact",8,4)->nullable();	
            $table->float("sdacha_gaza_prirod_plan",8,4)->nullable();	
            $table->float("sdacha_gaza_prirod_fact",8,4)->nullable();
            $table->float("raskhod_prirod_plan",8,4)->nullable();
            $table->float("raskhod_prirod_fact",8,4)->nullable();						
            $table->float("pererabotka_gaza_prirod_plan",8,4)->nullable(); 
            $table->float("pererabotka_gaza_prirod_fact",8,4)->nullable();
            $table->float("dobycha_gaza_poput_plan",8,4)->nullable();
            $table->float("dobycha_gaza_poput_fact",8,4)->nullable(); 
            $table->float("sdacha_gaza_poput_plan",8,4)->nullable();
            $table->float("sdacha_gaza_poput_fact",8,4)->nullable();
            $table->float("raskhod_poput_plan",8,4)->nullable();
            $table->float("raskhod_poput_fact",8,4)->nullable();
            $table->float("raskhod_syraya_poput_plan",8,4)->nullable();
            $table->float("raskhod_syraya_poput_fact",8,4)->nullable();
            $table->float("raskhod_syraya_tovarnaya_plan",8,4)->nullable(); 
            $table->float("raskhod_tovarnaya_poput_fact",8,4)->nullable();
            $table->float("pererabotka_gaza_poput_plan",8,4)->nullable();
            $table->float("pererabotka_gaza_poput_fact",8,4)->nullable();
            $table->float("poput_tech_poteri",8,4)->nullable();
            $table->float("poput_razresheno_sjiganie",8,4)->nullable();
            $table->float("ppd_zakachka_morskoi_vody_plan",8,4)->nullable();
            $table->float("ppd_zakachka_morskoi_vody_fact",8,4)->nullable();
            $table->float("ppd_zakachka_stochnoi_vody_plan",8,4)->nullable();
            $table->float("ppd_zakachka_stochnoi_vody_fact",8,4)->nullable();
            $table->float("ppd_zakachka_albsen_vody_plan",8,4)->nullable();
            $table->float("ppd_zakachka_albsen_vody_fact",8,4)->nullable();
            $table->float("ppd_zakachka_gaza_plan",8,4)->nullable();
            $table->float("ppd_zakachka_gaza_fact",8,4)->nullable();
            $table->float("ppd_zakachka_plast_poput_vody_plan",8,4)->nullable();
            $table->float("ppd_zakachka_plast_poput_vody_fact",8,4)->nullable();
            $table->float("ppd_zakachka_plast_apsk_vody_plan",8,4)->nullable();
            $table->float("ppd_zakachka_plast_apsk_vody_fact",8,4)->nullable();
            $table->float("ppd_zakachka_voljskoy_vody_plan",8,4)->nullable();
            $table->float("ppd_zakachka_voljskoy_vody_fact",8,4)->nullable();
            $table->float("ppd_zakachka_senopal_vody_plan",8,4)->nullable();
            $table->float("ppd_zakachka_senopal_vody_fact",8,4)->nullable();
            $table->float("otm_iz_burenia_skv_plan",8,4)->nullable();
            $table->float("otm_iz_burenia_skv_fact",8,4)->nullable();
            $table->float("otm_burenie_prohodka_plan",8,4)->nullable();
            $table->float("otm_burenie_prohodka_fact",8,4)->nullable();
            $table->float("otm_krs_skv_plan",8,4)->nullable();
            $table->float("otm_krs_skv_fact",8,4)->nullable();
            $table->float("otm_prs_skv_plan",8,4)->nullable();
            $table->float("otm_prs_skv_fact",8,4)->nullable();
            $table->float("cpp_zakachka_para_plan",8,4)->nullable();
            $table->float("cpp_zakachka_para_fact",8,4)->nullable();
            $table->float("fond_neftedob_ef",8,4)->nullable();
            $table->float("fond_neftedob_df",8,4)->nullable();
            $table->float("fond_neftedob_in_work",8,4)->nullable();
            $table->float("fond_neftedob_prs",8,4)->nullable();
            $table->float("fond_neftedob_oprs",8,4)->nullable();
            $table->float("fond_neftedob_krs",8,4)->nullable();
            $table->float("fond_neftedob_okrs",8,4)->nullable();
            $table->float("fond_neftedob_well_survey",8,4)->nullable();
            $table->float("fond_neftedob_others",8,4)->nullable();
            $table->float("fond_neftedob_bd",8,4)->nullable();
            $table->float("fond_neftedob_osvoenie",8,4)->nullable();
            $table->float("fond_neftedob_ofls",8,4)->nullable();
            $table->float("fond_neftedob_nrs",8,4)->nullable();
            $table->float("fond_neftedob_prostoy",8,4)->nullable();
            $table->float("fond_neftedob_prostoy_el",8,4)->nullable();
            $table->float("fond_neftedob_svabirovanie",8,4)->nullable();
            $table->float("fond_neftedob_period",8,4)->nullable();
            $table->float("fond_neftedob_vysokoobvod",8,4)->nullable();
            $table->float("fond_nagnetat_ef",8,4)->nullable();
            $table->float("fond_nagnetat_df",8,4)->nullable();
            $table->float("fond_nagnetat_in_work",8,4)->nullable();
            $table->float("fond_nagnetat_prs",8,4)->nullable();
            $table->float("fond_nagnetat_oprs",8,4)->nullable();
            $table->float("fond_nagnetat_krs",8,4)->nullable();
            $table->float("fond_nagnetat_okrs",8,4)->nullable();
            $table->float("fond_nagnetat_well_survey",8,4)->nullable();
            $table->float("fond_nagnetat_others",8,4)->nullable();
            $table->float("fond_nagnetat_bd",8,4)->nullable();
            $table->float("fond_nagnetat_osvoenie",8,4)->nullable();
            $table->float("fond_nagnetat_ofls",8,4)->nullable();
            $table->float("fond_nagnetat_konv",8,4)->nullable();
            $table->float("fond_nagnetat_ostanovka",8,4)->nullable();
            $table->float("fond_nagnetat_neftedob_fls",8,4)->nullable();
            $table->float("fond_nagnetat_neftedob_konserv",8,4)->nullable();
            $table->integer("chem_prod_zakacka_demulg_amount")->nullable();
            $table->float("chem_prod_zakacka_demulg_plan",8,4)->nullable();
            $table->float("chem_prod_zakacka_demulg_fact",8,4)->nullable();
            $table->integer("chem_prod_zakacka_bakteracid_amount")->nullable();
            $table->float("chem_prod_zakacka_bakteracid_plan",8,4)->nullable();
            $table->float("chem_prod_zakacka_bakteracid_fact",8,4)->nullable();
            $table->integer("chem_prod_zakacka_ingibator_korrozin_amount")->nullable();
            $table->float("chem_prod_zakacka_ingibator_korrozin_plan",8,4)->nullable();
            $table->float("chem_prod_zakacka_ingibator_korrozin_fact",8,4)->nullable();
            $table->integer("chem_prod_zakacka_ingibator_soleotloj_amount")->nullable();
            $table->float("chem_prod_zakacka_ingibator_soleotloj_plan",8,4)->nullable();
            $table->float("chem_prod_zakacka_ingibator_soleotloj_fact",8,4)->nullable();
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
        Schema::dropIfExists('d_z_odays');
    }
}

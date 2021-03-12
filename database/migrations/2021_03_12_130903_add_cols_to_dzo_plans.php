<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToDzoPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_plans', function (Blueprint $table) {
            $table->float('plan_oil_dlv',32,8)->nullable();
            $table->float('plan_gk_dlv',32,8)->nullable();
            $table->float('plan_liq',32,8)->nullable();
            $table->float('plan_par',32,8)->nullable();
            $table->float('plan_gas',32,8)->nullable();
            $table->float('plan_gas_dlv',32,8)->nullable();
            $table->float('plan_otm_iz_burenia_skv',32,8)->nullable();
            $table->float('plan_otm_burenie_prohodka',32,8)->nullable();
            $table->float('plan_otm_krs_skv_plan',32,8)->nullable();
            $table->float('plan_otm_prs_skv_plan',32,8)->nullable();
            $table->float('plan_chem_prod_zakacka_demulg',32,8)->nullable();
            $table->float('plan_chem_prod_zakacka_bakteracid',32,8)->nullable();
            $table->float('plan_chem_prod_zakacka_ingibator_korrozin',32,8)->nullable();
            $table->float('plan_chem_prod_zakacka_ingibator_soleotloj',32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_plans', function (Blueprint $table) {
            //
        });
    }
}

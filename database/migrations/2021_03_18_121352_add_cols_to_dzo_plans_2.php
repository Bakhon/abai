<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToDzoPlans2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_plans', function (Blueprint $table) {
            $table->float('plan_oil_opek',32,8)->nullable();
            $table->float('plan_oil_dlv_opek',32,8)->nullable();
            
            $table->float('plan_prirod_gas',32,8)->nullable();
            $table->float('plan_prirod_gas_dlv',32,8)->nullable();
            $table->float('plan_prirod_gas_raskhod',32,8)->nullable();
            $table->float('plan_prirod_gas_pererabotka',32,8)->nullable();
            $table->float('plan_prirod_gas_burn',32,8)->nullable();

            $table->float('plan_poput_gas',32,8)->nullable();
            $table->float('plan_poput_gas_dlv',32,8)->nullable();
            $table->float('plan_poput_gas_raskhod',32,8)->nullable();
            $table->float('plan_poput_gas_pererabotka',32,8)->nullable();
            $table->float('plan_poput_gas_burn',32,8)->nullable();

            $table->float('plan_liq_ocean',32,8)->nullable();
            $table->float('plan_liq_waste',32,8)->nullable();
            $table->float('plan_liq_albsen',32,8)->nullable();
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

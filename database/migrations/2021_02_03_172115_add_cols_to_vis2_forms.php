<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToVis2Forms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vis2_forms', function (Blueprint $table) {
            $table->float("oil_plan",32,8)->nullable();
            $table->float("gk_plan",32,8)->nullable();	
            $table->float("liq_plan",32,8);
            $table->float("gas_plan",32,8)->nullable();
            $table->float("inj_plan",32,8)->nullable();
            $table->float("oil_dlv_plan",32,8)->nullable();
            $table->float("liq_fact",32,8)->nullable();
            $table->float("inj_fact",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vis2_forms', function (Blueprint $table) {
            //
        });
    }
}

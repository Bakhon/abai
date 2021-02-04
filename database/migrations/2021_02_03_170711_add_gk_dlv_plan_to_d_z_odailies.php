<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGkDlvPlanToDZOdailies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_z_odailies', function (Blueprint $table) {
            $table->float("gk_dlv_plan",32,8)->nullable();	
            $table->float("gk_dlv_fact",32,8)->nullable();	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_z_odailies', function (Blueprint $table) {
            //
        });
    }
}

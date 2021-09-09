<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTemperaturesOmgNgduWell extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_n_g_d_u_wells', function (Blueprint $table) {
            $table->renameColumn('temperature', 'temperature_zu');
            $table->float('temperature_well')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_n_g_d_u_wells', function (Blueprint $table) {
            $table->renameColumn('temperature_zu', 'temperature');
            $table->dropColumn('temperature_well');
        });
    }
}

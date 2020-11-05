<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmgNGDUSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('omg_n_g_d_u_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('field')->nullable();
            $table->integer('ngdu_id')->nullable();
            $table->integer('cdng_id')->nullable();
            $table->integer('gu_id')->nullable();
            $table->integer('zu_id')->nullable();
            $table->integer('well_id')->nullable();
            $table->date('date');
            $table->float('daily_fluid_production', 8, 2)->nullable();
            $table->float('bsw', 8, 2)->nullable();
            $table->float('surge_tank_pressure', 8, 2)->nullable();
            $table->float('pump_discharge_pressure', 8, 2)->nullable();
            $table->float('heater_inlet_pressure', 8, 2)->nullable();
            $table->float('heater_output_pressure', 8, 2)->nullable();
            $table->float('kormass_number', 8, 2)->nullable();
            $table->float('pressure', 8, 2)->nullable();
            $table->float('temperature', 8, 2)->nullable();
            $table->float('daily_fluid_production_kormass', 8, 2)->nullable();
            $table->integer('cruser_id');
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
        Schema::dropIfExists('omg_n_g_d_u_s');
    }
}

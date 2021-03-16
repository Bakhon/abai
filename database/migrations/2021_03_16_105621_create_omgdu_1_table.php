<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmgdu1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('omg_n_g_d_u_s_1')) {
            Schema::create('omg_n_g_d_u_s_1', function($table){
                $table->bigIncrements('id');
                $table->bigInteger('field_id')->unsigned()->nullable();
                $table->bigInteger('ngdu_id')->unsigned()->nullable();
                $table->bigInteger('cdng_id')->unsigned()->nullable();
                $table->bigInteger('gu_id')->unsigned()->nullable();
                $table->bigInteger('zu_id')->unsigned()->nullable();
                $table->bigInteger('well_id')->unsigned()->nullable();
                $table->date('date');
                $table->float('daily_fluid_production')->nullable();
                $table->float('daily_water_production')->nullable();
                $table->float('daily_oil_production')->nullable();
                $table->float('daily_gas_production_in_sib')->nullable();
                $table->float('bsw')->nullable();
                $table->float('surge_tank_pressure')->nullable();
                $table->float('pump_discharge_pressure')->nullable();
                $table->float('heater_inlet_pressure')->nullable();
                $table->float('heater_output_pressure')->nullable();
                $table->float('kormass_number')->nullable();
                $table->float('pressure')->nullable();
                $table->float('temperature')->nullable();
                $table->float('daily_fluid_production_kormass')->nullable();
                $table->bigInteger('cruser_id');
                $table->timestamps();
                $table->tinyInteger('editable')->default(1);
            });

             Schema::table('omg_n_g_d_u_s_1', function (Blueprint $table) {
                 $table->foreign('field_id')->references('id')->on('fields')->onDelete('set null');
                 $table->foreign('gu_id')->references('id')->on('gus')->onDelete('set null');
                 $table->foreign('ngdu_id')->references('id')->on('ngdus')->onDelete('set null');
                 $table->foreign('cdng_id')->references('id')->on('cdngs')->onDelete('set null');
                 $table->foreign('zu_id')->references('id')->on('zus')->onDelete('set null');
                 $table->foreign('well_id')->references('id')->on('wells')->onDelete('set null');
             });

             $this->seed();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('omg_n_g_d_u_s_1');
    }

    private function seed()
    {
        DB::statement('INSERT omg_n_g_d_u_s_1 SELECT * FROM omg_n_g_d_u_s');
    }
}

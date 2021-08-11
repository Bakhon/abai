<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmgNGDUZusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('omg_n_g_d_u_zus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('zu_id')->unsigned()->nullable();
            $table->date('date');
            $table->float('daily_fluid_production')->nullable();
            $table->float('daily_water_production')->nullable();
            $table->float('daily_oil_production')->nullable();
            $table->float('gas_factor')->nullable();
            $table->float('bsw')->nullable();
            $table->float('pressure')->nullable();
            $table->float('temperature')->nullable();
            $table->float("sg_oil",4,2)->nullable();
            $table->float("sg_gas",4,2)->nullable();
            $table->float("sg_water",4,2)->nullable();
            $table->bigInteger('cruser_id');
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
        Schema::dropIfExists('omg_n_g_d_u_zus');


    }
}

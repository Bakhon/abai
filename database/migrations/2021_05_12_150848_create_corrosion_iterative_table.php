<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrosionIterativeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corrosion_iterative', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('gu_id')->nullable();
            $table->float('background_corrosion_velocity', 8, 4)->nullable();
            $table->date('date_for_corrosion');
            $table->float('carbon_dioxide', 8, 4)->nullable();
            $table->date('date_for_carbon_dioxide');
            $table->float('volume_fractions_for_carbon_dioxide');
            $table->float('surge_tank_pressure');
            $table->float('carbon_dioxide_pressure');
            $table->float('hydrogen_sulfide_in_gas');
            $table->date('date_for_hydrogen_sulfide');
            $table->float('volume_fractions_for_hydrogen_sulfide');
            $table->float('hydrogen_sulfide_in_gas_pressure');
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
        Schema::dropIfExists('corrosion_iterative');
    }
}

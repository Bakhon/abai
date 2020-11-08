<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOilGasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oil_gases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('other_objects_id')->nullable();
            $table->integer('ngdu_id')->nullable();
            $table->integer('cdng_id')->nullable();
            $table->integer('gu_id')->nullable();
            $table->integer('zu_id')->nullable();
            $table->integer('well_id')->nullable();
            $table->date('date');
            $table->float('water_density_at_20', 8, 4)->nullable();
            $table->float('oil_viscosity_at_20', 8, 4)->nullable();
            $table->float('oil_viscosity_at_40', 8, 4)->nullable();
            $table->float('oil_viscosity_at_50', 8, 4)->nullable();
            $table->float('oil_viscosity_at_60', 8, 4)->nullable();
            $table->float('hydrogen_sulfide_in_gas', 8, 4)->nullable();
            $table->float('oxygen_in_gas', 8, 4)->nullable();
            $table->float('carbon_dioxide_in_gas', 8, 4)->nullable();
            $table->float('gas_density_at_20', 8, 4)->nullable();
            $table->float('gas_viscosity_at_20', 8, 4)->nullable();
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
        Schema::dropIfExists('oil_gases');
    }
}

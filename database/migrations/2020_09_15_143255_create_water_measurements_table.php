<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_measurements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('other_objects_id')->nullable();
            $table->integer('ngdu_id')->nullable();
            $table->integer('cdng_id')->nullable();
            $table->integer('gu_id')->nullable();
            $table->integer('zu_id')->nullable();
            $table->integer('well_id')->nullable();
            $table->dateTime('date', 0);
            $table->float('hydrocarbonate_ion', 8, 2)->nullable();
            $table->float('carbonate_ion', 8, 2)->nullable();
            $table->float('sulphate_ion', 8, 2)->nullable();
            $table->float('chlorum_ion', 8, 2)->nullable();
            $table->float('calcium_ion', 8, 2)->nullable();
            $table->float('magnesium_ion', 8, 2)->nullable();
            $table->float('potassium_ion_sodium_ion', 8, 2)->nullable();
            $table->float('density', 8, 2)->nullable();
            $table->float('ph', 8, 2)->nullable();
            $table->float('mineralization', 8, 2)->nullable();
            $table->float('total_hardness', 8, 2)->nullable();
            $table->integer('water_type_by_sulin_id')->nullable()->nullable();
            $table->float('content_of_petrolium_products', 8, 2)->nullable();
            $table->float('mechanical_impurities', 8, 2)->nullable();
            $table->float('strontium_content', 8, 2)->nullable();
            $table->float('barium_content', 8, 2)->nullable();
            $table->float('total_iron_content', 8, 2)->nullable();
            $table->float('ferric_iron_content', 8, 2)->nullable();
            $table->float('ferrous_iron_content', 8, 2)->nullable();
            $table->float('hydrogen_sulfide', 8, 2)->nullable();
            $table->float('oxygen', 8, 2)->nullable();
            $table->float('carbon_dioxide', 8, 2)->nullable();
            $table->integer('sulphate_reducing_bacteria_id')->nullable();
            $table->integer('hydrocarbon_oxidizing_bacteria_id')->nullable();
            $table->integer('thionic_bacteria_id')->nullable();
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
        Schema::dropIfExists('water_measurements');
    }
}

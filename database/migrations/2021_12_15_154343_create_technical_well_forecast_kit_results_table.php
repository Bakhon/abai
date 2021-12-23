<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalWellForecastKitResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_well_forecast_kit_results', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('kit_id');
            $table->foreign('kit_id')
                ->references('id')
                ->on('technical_well_forecast_kits');

            $table->decimal('permanent_stop_coefficient');

            $table->json('enabled_uwis');
            $table->json('stopped_uwis');

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
        Schema::dropIfExists('technical_well_forecast_kit_results');
    }
}

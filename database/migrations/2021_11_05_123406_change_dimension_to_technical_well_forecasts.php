<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDimensionToTechnicalWellForecasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_well_forecasts', function (Blueprint $table) {
            $table->decimal('active_hours', 14, 12)->change();
            $table->decimal('paused_hours', 14, 12)->change();
            $table->decimal('prs_portion', 14, 12)->change();

            $table->decimal('oil', 18, 12)->change();
            $table->decimal('oil_forecast', 18, 12)->change();
            $table->decimal('oil_loss', 18, 12)->change();
            $table->decimal('oil_tech_loss', 18, 12)->change();
            $table->decimal('liquid', 18, 12)->change();
            $table->decimal('liquid_forecast', 18, 12)->change();
            $table->decimal('liquid_loss', 18, 12)->change();
            $table->decimal('liquid_tech_loss', 18, 12)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_well_forecasts', function (Blueprint $table) {
            $table->unsignedInteger('active_hours')->change();
            $table->unsignedInteger('paused_hours')->change();

            $table->float('prs_portion', 12, 2)->change();
            $table->float('oil', 12, 2)->change();
            $table->float('oil_forecast', 12, 2)->change();
            $table->float('oil_loss', 12, 2)->change();
            $table->float('oil_tech_loss', 12, 2)->change();
            $table->float('liquid', 12, 2)->change();
            $table->float('liquid_forecast', 12, 2)->change();
            $table->float('liquid_loss', 12, 2)->change();
            $table->float('liquid_tech_loss', 12, 2)->change();
        });
    }
}

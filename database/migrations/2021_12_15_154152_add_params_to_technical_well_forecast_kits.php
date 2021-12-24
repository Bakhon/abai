<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParamsToTechnicalWellForecastKits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_well_forecast_kits', function (Blueprint $table) {
            $table->json('permanent_stop_coefficients')->nullable();

            $table->unsignedInteger('total_variants')->nullable();

            $table->unsignedInteger('calculated_variants')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_well_forecast_kits', function (Blueprint $table) {
            $table->dropColumn([
                'permanent_stop_coefficients',
                'total_variants',
                'calculated_variants'
            ]);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogIdUwiDateMonthIndexToTechnicalWellForecasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_well_forecasts', function (Blueprint $table) {
            $table->index(
                ["log_id", "uwi", "date_month"],
                "technical_well_forecasts_log_id_uwi_date_month_index"
            );
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
            $table->dropForeign(['log_id']);

            $table->dropIndex('technical_well_forecasts_log_id_uwi_date_month_index');
        });

        Schema::table('technical_well_forecasts', function (Blueprint $table) {
            $table->foreign('log_id')
                ->references('id')
                ->on('economic_data_logs');
        });
    }
}

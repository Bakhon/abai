<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogIdHasStatusIdStatusIdDateMonthUwiIndexToTechnicalWellForecasts extends Migration
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
                ["log_id", "has_status_id", "status_id", "date_month", "uwi"],
                "technical_well_forecasts_log_id_has_status_id_index"
            );

            $table->index(
                ["log_id", "has_loss_status_id", "loss_status_id", "date_month", "uwi"],
                "technical_well_forecasts_log_id_has_loss_status_id_index"
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

            $table->dropIndex('technical_well_forecasts_log_id_has_status_id_index');

            $table->dropIndex('technical_well_forecasts_log_id_has_loss_status_id_index');
        });

        Schema::table('technical_well_forecasts', function (Blueprint $table) {
            $table->foreign('log_id')
                ->references('id')
                ->on('economic_data_logs');
        });
    }
}

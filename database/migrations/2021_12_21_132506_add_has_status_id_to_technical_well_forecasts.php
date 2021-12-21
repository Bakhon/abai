<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHasStatusIdToTechnicalWellForecasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_well_forecasts', function (Blueprint $table) {
            $table->boolean('has_status_id')->default(false);
            $table->boolean('has_loss_status_id')->default(false);
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
            $table->dropColumn(['has_status_id', 'has_loss_status_id']);
        });
    }
}

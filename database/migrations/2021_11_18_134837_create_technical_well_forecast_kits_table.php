<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalWellForecastKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_well_forecast_kits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->unsignedBigInteger('technical_log_id');
            $table->foreign('technical_log_id')
                ->references('id')
                ->on('economic_data_logs');

            $table->unsignedBigInteger('economic_log_id');
            $table->foreign('economic_log_id')
                ->references('id')
                ->on('economic_data_logs');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

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
        Schema::dropIfExists('technical_well_forecast_kits');
    }
}

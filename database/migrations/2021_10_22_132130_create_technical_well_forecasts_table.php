<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalWellForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_well_forecasts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('log_id');
            $table->foreign('log_id')
                ->references('id')
                ->on('economic_data_logs');

            $table->unsignedSmallInteger('status_id')->nullable();
            $table->foreign('status_id')
                ->references('id')
                ->on('technical_well_statuses');

            $table->unsignedSmallInteger('loss_status_id')->nullable();
            $table->foreign('loss_status_id')
                ->references('id')
                ->on('technical_well_loss_statuses');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->string('uwi');
            $table->date('date');

            $table->unsignedInteger('active_hours');
            $table->unsignedInteger('paused_hours');

            $table->float('prs_portion', 12, 2);
            $table->float('oil', 12, 2);
            $table->float('oil_forecast', 12, 2);
            $table->float('oil_loss', 12, 2);
            $table->float('oil_tech_loss', 12, 2);
            $table->float('liquid', 12, 2);
            $table->float('liquid_forecast', 12, 2);
            $table->float('liquid_loss', 12, 2);
            $table->float('liquid_tech_loss', 12, 2);

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
        Schema::dropIfExists('technical_well_forecasts');
    }
}

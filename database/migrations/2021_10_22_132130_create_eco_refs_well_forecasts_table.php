<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsWellForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_well_forecasts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('log_id');
            $table->foreign('log_id')
                ->references('id')
                ->on('economic_data_logs');

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')
                ->references('id')
                ->on('users');

            $table->string('uwi');
            $table->date('date');

            $table->unsignedInteger('active_days');
            $table->unsignedInteger('paused_days');

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
        Schema::dropIfExists('eco_refs_well_forecasts');
    }
}

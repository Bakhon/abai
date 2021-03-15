<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalDataForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_data_forecasts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('well_id', 15)->index();
            $table->date('date')->index();
            $table->float('oil', 6, 2)->nullable();
            $table->float('liquid', 6, 2)->nullable();
            $table->float('days_worked', 5, 2)->nullable();
            $table->smallInteger('prs')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('gu_id')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->timestamps();

            $table->foreign('source_id')
                ->references('id')
                ->on('technical_structure_sources')
                ->onDelete('set null');

            $table->foreign('gu_id')
                ->references('id')
                ->on('technical_structure_gus')
                ->onDelete('set null');

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('editor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technical_data_forecasts');
    }
}

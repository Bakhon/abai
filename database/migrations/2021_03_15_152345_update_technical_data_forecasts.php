<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTechnicalDataForecasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_data_forecasts', function (Blueprint $table) {
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('log_id')->nullable();
            $table->unique(['well_id', 'date'], 'well_date');

            $table->foreign('log_id')
                ->references('id')
                ->on('technical_uploaded_log')
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
        Schema::table('technical_data_forecasts', function (Blueprint $table) {
            $table->dropUnique('well_date');
            $table->dropColumn(['comment']);
            $table->dropColumn(['log_id']);
        });
    }
}

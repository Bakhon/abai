<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTechnicalDataForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_data_forecasts', function (Blueprint $table) {
            $table->dropUnique('well_date');
            $table->unique(['source_id', 'well_id', 'date'], 'source_well_date');
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
            $table->dropUnique('source_well_date');
            $table->unique(['well_id', 'date'], 'well_date');
        });
    }
}

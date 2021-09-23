<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueToTechnicalDataForecasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_data_forecasts', function (Blueprint $table) {
            $table->dropForeign(['source_id']);

            $table->dropUnique('source_well_date');
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
            $table->foreign('source_id')
                ->references('id')
                ->on('eco_refs_companies_ids');

            $table->unique(['source_id', 'well_id', 'date'], 'source_well_date');
        });
    }
}

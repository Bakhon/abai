<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceIdCompanyIdDateIndexToTechnicalDataForecasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_data_forecasts', function (Blueprint $table) {
            $table->index(
                ["source_id", "company_id", "date"],
                "technical_data_forecasts_source_id_company_id_date_index"
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
        Schema::table('technical_data_forecasts', function (Blueprint $table) {
            $table->dropIndex('technical_data_forecasts_source_id_company_id_date_index');
        });
    }
}

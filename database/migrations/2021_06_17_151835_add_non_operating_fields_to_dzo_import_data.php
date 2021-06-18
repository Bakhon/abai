<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNonOperatingFieldsToDzoImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_data', function (Blueprint $table) {
            $table->float("oil_production_fact_absolute",32,8)->nullable();
            $table->float("oil_delivery_fact_absolute",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_import_data', function (Blueprint $table) {
            $table->dropColumn(
                'oil_production_fact_absolute',
                'oil_delivery_fact_absolute',
            );
        });
    }
}

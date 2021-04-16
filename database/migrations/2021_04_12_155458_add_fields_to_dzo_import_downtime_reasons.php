<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDzoImportDowntimeReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_downtime_reasons', function (Blueprint $table) {
            $table->float("chrf_restriction_downtime_production_wells_count",32,8)->nullable();
            $table->float("chrf_restriction_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("chrf_restriction_downtime_injection_wells_count",32,8)->nullable();
            $table->float("unprofitable_downtime_production_wells_count",32,8)->nullable();
            $table->float("unprofitable_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("unprofitable_downtime_injection_wells_count",32,8)->nullable();
            $table->float("drilling_restriction_downtime_production_wells_count",32,8)->nullable();
            $table->float("drilling_restriction_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("drilling_restriction_downtime_injection_wells_count",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_import_downtime_reasons', function (Blueprint $table) {
            //
        });
    }
}

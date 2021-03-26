<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DzoImportDowntimeReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('dzo_import_downtime_reasons');
        Schema::create('dzo_import_downtime_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('import_data_id');
            $table->float("prs_downtime_production_wells_count",32,8)->nullable();
            $table->float("prs_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("prs_downtime_injection_wells_count",32,8)->nullable();
            $table->float("prs_wait_downtime_production_wells_count",32,8)->nullable();
            $table->float("prs_wait_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("prs_wait_downtime_injection_wells_count",32,8)->nullable();
            $table->float("krs_downtime_production_wells_count",32,8)->nullable();
            $table->float("krs_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("krs_downtime_injection_wells_count",32,8)->nullable();
            $table->float("krs_wait_downtime_production_wells_count",32,8)->nullable();
            $table->float("krs_wait_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("krs_wait_downtime_injection_wells_count",32,8)->nullable();
            $table->float("well_survey_downtime_production_wells_count",32,8)->nullable();
            $table->float("well_survey_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("well_survey_downtime_injection_wells_count",32,8)->nullable();
            $table->float("other_downtime_production_wells_count",32,8)->nullable();
            $table->float("other_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("other_downtime_injection_wells_count",32,8)->nullable();
            $table->float("glut_downtime_production_wells_count",32,8)->nullable();
            $table->float("glut_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("glut_downtime_injection_wells_count",32,8)->nullable();
            $table->float("impulse_replacement_downtime_production_wells_count",32,8)->nullable();
            $table->float("impulse_replacement_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("impulse_replacement_downtime_injection_wells_count",32,8)->nullable();
            $table->float("electrical_part_downtime_production_wells_count",32,8)->nullable();
            $table->float("electrical_part_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("electrical_part_downtime_injection_wells_count",32,8)->nullable();
            $table->float("ground_repair_downtime_production_wells_count",32,8)->nullable();
            $table->float("ground_repair_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("ground_repair_downtime_injection_wells_count",32,8)->nullable();
            $table->float("periodic_downtime_production_wells_count",32,8)->nullable();
            $table->float("periodic_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("periodic_downtime_injection_wells_count",32,8)->nullable();
            $table->float("production_restriction_downtime_production_wells_count",32,8)->nullable();
            $table->float("production_restriction_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("production_restriction_downtime_injection_wells_count",32,8)->nullable();
            $table->float("well_treatment_downtime_production_wells_count",32,8)->nullable();
            $table->float("well_treatment_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("well_treatment_downtime_injection_wells_count",32,8)->nullable();
            $table->float("highly_watered_downtime_production_wells_count",32,8)->nullable();
            $table->float("highly_watered_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("highly_watered_downtime_injection_wells_count",32,8)->nullable();
            $table->float("limited_download_downtime_production_wells_count",32,8)->nullable();
            $table->float("limited_download_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("limited_download_downtime_injection_wells_count",32,8)->nullable();
            $table->float("profile_alignment_downtime_production_wells_count",32,8)->nullable();
            $table->float("profile_alignment_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("profile_alignment_downtime_injection_wells_count",32,8)->nullable();
            $table->float("coiltubing_downtime_production_wells_count",32,8)->nullable();
            $table->float("coiltubing_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("coiltubing_downtime_injection_wells_count",32,8)->nullable();
        });

        Schema::table('dzo_import_downtime_reasons', function($table) {
           $table->foreign('import_data_id')->references('id')->on('dzo_import_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dzo_import_downtime_reasons');
    }
}

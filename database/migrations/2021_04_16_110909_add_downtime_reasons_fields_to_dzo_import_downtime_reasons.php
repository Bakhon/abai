<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDowntimeReasonsFieldsToDzoImportDowntimeReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_downtime_reasons', function (Blueprint $table) {
            $table->float("waiting_pump_downtime_production_wells_count",32,8)->nullable();
            $table->float("waiting_pump_production_wells_oil_loss",32,8)->nullable();
            $table->float("waiting_pump_injection_wells_count",32,8)->nullable();
            $table->float("waiting_swabbing_downtime_production_wells_count",32,8)->nullable();
            $table->float("waiting_swabbing_production_wells_oil_loss",32,8)->nullable();
            $table->float("waiting_swabbing_injection_wells_count",32,8)->nullable();
            $table->float("regulate_stopped_downtime_production_wells_count",32,8)->nullable();
            $table->float("regulate_stopped_production_wells_oil_loss",32,8)->nullable();
            $table->float("regulate_stopped_injection_wells_count",32,8)->nullable();
            $table->float("waiting_ppr_downtime_production_wells_count",32,8)->nullable();
            $table->float("waiting_ppr_production_wells_oil_loss",32,8)->nullable();
            $table->float("waiting_ppr_injection_wells_count",32,8)->nullable();
            $table->float("impact_prs_downtime_production_wells_count",32,8)->nullable();
            $table->float("impact_prs_production_wells_oil_loss",32,8)->nullable();
            $table->float("impact_prs_injection_wells_count",32,8)->nullable();
            $table->float("mkd_stop_downtime_production_wells_count",32,8)->nullable();
            $table->float("mkd_stop_production_wells_oil_loss",32,8)->nullable();
            $table->float("mkd_stop_injection_wells_count",32,8)->nullable();
            $table->float("technological_downtime_downtime_production_wells_count",32,8)->nullable();
            $table->float("technological_downtime_production_wells_oil_loss",32,8)->nullable();
            $table->float("technological_downtime_injection_wells_count",32,8)->nullable();
            $table->float("pns_production_wells_count",32,8)->nullable();
            $table->float("pns_production_wells_oil_loss",32,8)->nullable();
            $table->float("pns_injection_wells_count",32,8)->nullable();
            $table->float("vns_production_wells_count",32,8)->nullable();
            $table->float("vns_production_wells_oil_loss",32,8)->nullable();
            $table->float("vns_injection_wells_count",32,8)->nullable();
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
            $table->dropColumn(
                'waiting_pump_downtime_production_wells_count',
                'waiting_pump_production_wells_oil_loss',
                'waiting_pump_injection_wells_count',
                'waiting_swabbing_downtime_production_wells_count',
                'waiting_swabbing_production_wells_oil_loss',
                'waiting_swabbing_injection_wells_count',
                'regulate_stopped_downtime_production_wells_count',
                'regulate_stopped_production_wells_oil_loss',
                'regulate_stopped_injection_wells_count',
                'waiting_ppr_downtime_production_wells_count',
                'waiting_ppr_production_wells_oil_loss',
                'waiting_ppr_injection_wells_count',
                'impact_prs_downtime_production_wells_count',
                'impact_prs_production_wells_oil_loss',
                'impact_prs_injection_wells_count',
                'mkd_stop_downtime_production_wells_count',
                'mkd_stop_production_wells_oil_loss',
                'mkd_stop_injection_wells_count',
                'technological_downtime_downtime_production_wells_count',
                'technological_downtime_production_wells_oil_loss',
                'technological_downtime_injection_wells_count',
                'pns_production_wells_count',
                'pns_production_wells_oil_loss',
                'pns_injection_wells_count',
                'vns_production_wells_count',
                'vns_production_wells_oil_loss',
                'vns_injection_wells_count'
            );
        });
    }
}

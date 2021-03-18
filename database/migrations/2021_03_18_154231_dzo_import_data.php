<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DzoImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dzo_import_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->text("dzo_name");
            $table->float("oil_production_fact",32,8)->nullable();
            $table->float("oil_delivery_fact",32,8)->nullable();
            $table->float("oil_delivery_by_stations_fact",32,8)->nullable();
            $table->float("condensate_production_fact",32,8)->nullable();
            $table->float("condensate_delivery_fact",32,8)->nullable();
            $table->float("condensate_delivery_by_stations_fact",32,8)->nullable();
            $table->float("stock_of_goods_delivery_fact",32,8)->nullable();
            $table->float("natural_gas_production_fact",32,8)->nullable();
            $table->float("natural_gas_delivery_fact",32,8)->nullable();
            $table->float("natural_gas_expenses_for_own_fact",32,8)->nullable();
            $table->float("natural_gas_processing_fact",32,8)->nullable();
            $table->float("natural_gas_flaring_fact",32,8)->nullable();
            $table->float("associated_gas_production_fact",32,8)->nullable();
            $table->float("associated_gas_delivery_fact",32,8)->nullable();
            $table->float("associated_gas_expenses_for_own_fact",32,8)->nullable();
            $table->float("associated_gas_processing_fact",32,8)->nullable();
            $table->float("associated_gas_flaring_fact",32,8)->nullable();
            $table->float("agent_upload_total_water_injection_fact",32,8)->nullable();
            $table->float("agent_upload_seawater_injection_fact",32,8)->nullable();
            $table->float("agent_upload_waste_water_injection_fact",32,8)->nullable();
            $table->float("agent_upload_albsenomanian_water_injection_fact",32,8)->nullable();
            $table->float("agent_upload_stream_injection_fact",32,8)->nullable();
            $table->float("otm_wells_commissioning_from_drilling_fact",32,8)->nullable();
            $table->float("otm_drilling_fact",32,8)->nullable();
            $table->float("otm_well_workover_fact",32,8)->nullable();
            $table->float("otm_underground_workover",32,8)->nullable();
            $table->float("operating_production_fond",32,8)->nullable();
            $table->float("operating_injection_fond",32,8)->nullable();
            $table->float("active_production_fond",32,8)->nullable();
            $table->float("active_injection_fond",32,8)->nullable();
            $table->float("in_work_production_fond",32,8)->nullable();
            $table->float("in_work_injection_fond",32,8)->nullable();
            $table->float("in_idle_production_fond",32,8)->nullable();
            $table->float("in_idle_injection_fond",32,8)->nullable();
            $table->float("inactive_production_fond",32,8)->nullable();
            $table->float("inactive_injection_fond",32,8)->nullable();
            $table->float("developing_production_fond",32,8)->nullable();
            $table->float("developing_injection_fond",32,8)->nullable();
            $table->float("pending_liquidation_production_fond",32,8)->nullable();
            $table->float("pending_liquidation_injection_fond",32,8)->nullable();
            $table->float("in_conservation_production_fond",32,8)->nullable();
            $table->float("in_conservation_injection_fond",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dzo_import_data');
    }
}

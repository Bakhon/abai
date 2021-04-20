<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDzoFieldsToDzoImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_data', function (Blueprint $table) {
            $table->float("agent_upload_tech_water_injection_fact",32,8)->nullable();
            $table->float("agent_upload_volga_water_injection_fact",32,8)->nullable();
            $table->float("trial_operating_production_fond",32,8)->nullable();
            $table->float("trial_operating_injection_fond",32,8)->nullable();
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
                'agent_upload_tech_water_injection_fact',
                'agent_upload_volga_water_injection_fact',
                'trial_operating_production_fond',
                "trial_operating_injection_fond"
            );
        });
    }
}

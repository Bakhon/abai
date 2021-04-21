<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDzoFieldsToDzoImportFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_fields', function (Blueprint $table) {
            $table->float("agent_upload_tech_water_injection_fact",32,8)->nullable();
            $table->float("agent_upload_volga_water_injection_fact",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_import_fields', function (Blueprint $table) {
            $table->dropColumn(
                'agent_upload_tech_water_injection_fact',
                'agent_upload_volga_water_injection_fact'
            );
        });
    }
}

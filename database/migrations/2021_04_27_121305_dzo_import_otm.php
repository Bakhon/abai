<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DzoImportOtm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::dropIfExists('dzo_import_otm');
         Schema::create('dzo_import_otm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("dzo_name");
            $table->dateTime("date");
            $table->float("otm_well_workover_fact",32,8)->nullable();
            $table->float("otm_underground_workover",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dzo_import_otm');
    }
}

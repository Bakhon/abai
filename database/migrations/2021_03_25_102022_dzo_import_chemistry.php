<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DzoImportChemistry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('dzo_import_chemistries');
        Schema::create('dzo_import_chemistries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("dzo_name");
            $table->dateTime("date");
            $table->float("demulsifier",32,8)->nullable();
            $table->float("bactericide",32,8)->nullable();
            $table->float("corrosion_inhibitor",32,8)->nullable();
            $table->float("scale_inhibitor",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dzo_import_chemistries');
    }
}

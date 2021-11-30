<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveWaterWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('water_wells');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('water_wells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('lat', 12, 10)->nullable();
            $table->float('lon', 12, 10)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
}

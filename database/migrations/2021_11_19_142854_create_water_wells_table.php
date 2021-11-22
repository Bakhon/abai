<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_wells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('object_id')->nullable();
            $table->float('lat', 12, 10)->nullable();
            $table->float('lon', 12, 10)->nullable();
            $table->float('length', 13, 7)->nullable();
            $table->float('point_x', 12, 4)->nullable();
            $table->float('point_y', 12, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('water_wells');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewWaterWellsTable extends Migration
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
            $table->float('lat', 12, 10);
            $table->float('lon', 12, 10);
            $table->string('name');
            $table->string('type');
            $table->string('status');
            $table->integer('well_number')->nullable();
            $table->integer('well_type')->nullable();
            $table->year('drilling_date')->nullable();
            $table->softDeletes();
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

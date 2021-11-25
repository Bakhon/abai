<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterPipesPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_pipe_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('oil_pipe_id');
            $table->bigInteger('pipe_coord_id');
            $table->bigInteger('object_id')->nullable();
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
        Schema::dropIfExists('water_pipe_points');
    }
}

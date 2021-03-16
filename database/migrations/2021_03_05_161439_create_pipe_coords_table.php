<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePipeCoordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipe_coords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('map_pipe_id');
            $table->string('lat');
            $table->string('lon');
            $table->string('elevation');
            $table->string('h_distance');
            $table->string('m_distance');
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
        Schema::dropIfExists('pipe_coords');
    }
}

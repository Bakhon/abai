<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignIndexesPipeCoordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pipe_coords', function (Blueprint $table) {
            $table->bigInteger('map_pipe_id')->unsigned()->change();
            $table->foreign('map_pipe_id')->references('id')->on('map_pipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pipe_coords', function (Blueprint $table) {
            $table->dropForeign('map_pipe_id');
            $table->dropIndex('map_pipe_id');
        });
    }
}

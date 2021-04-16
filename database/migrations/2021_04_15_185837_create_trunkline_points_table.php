<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrunklinePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trunkline_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('end_point')->nullable();
            $table->bigInteger('ngdu_id')->unsigned()->nullable();
            $table->bigInteger('gu_id')->unsigned()->nullable();
            $table->bigInteger('point_end_id')->unsigned()->nullable();
            $table->bigInteger('map_pipe_id')->unsigned()->nullable();
            $table->string('lat');
            $table->string('lon');
            $table->float('elevation', 6, 2);
            $table->timestamps();


        });

        Schema::table('trunkline_points', function (Blueprint $table) {
            $table->foreign('ngdu_id')
                ->references('id')
                ->on('ngdus')
                ->onDelete('set null');

            $table->foreign('gu_id')
                ->references('id')
                ->on('gus')
                ->onDelete('set null');

            $table->foreign('map_pipe_id')
                ->references('id')
                ->on('map_pipes')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trunkline_points');
    }
}

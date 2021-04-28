<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroCalcResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_calc_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->float('length', 10, 2)->nullable();
            $table->float('qliq', 8, 2)->nullable();
            $table->float('bsw', 4, 2)->nullable();
            $table->float('gazf', 6, 2)->nullable();
            $table->float('press_start', 8, 2)->nullable();
            $table->float('press_end', 8, 2)->nullable();
            $table->float('temperature_start', 5, 2)->nullable();
            $table->float('temperature_end', 5, 2)->nullable();
            $table->string('start_point')->nullable();
            $table->string('end_point')->nullable();
            $table->unsignedBigInteger('map_pipe_id')->nullable();
            $table->unsignedBigInteger('trunkline_point_id')->nullable();
            $table->float('mix_speed_avg', 10, 4)->nullable();
            $table->float('fluid_speed', 10, 4)->nullable();
            $table->float('gaz_speed', 8, 4)->nullable();
            $table->string('flow_type')->nullable();
            $table->float('press_change', 10, 4)->nullable();
            $table->integer('break_qty')->unsigned(true)->nullable();
            $table->float('height_drop', 6, 2)->nullable();
            $table->timestamps();
        });

        Schema::table('hydro_calc_results', function (Blueprint $table) {
            $table->foreign('map_pipe_id')->references('id')->on('map_pipes')->onDelete('set null');
            $table->foreign('trunkline_point_id')->references('id')->on('trunkline_points')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hydro_calc_results');
    }
}

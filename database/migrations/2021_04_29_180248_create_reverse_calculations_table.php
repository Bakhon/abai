<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReverseCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reverse_calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->integer('outside_diameter')->nullable();
            $table->float('thickness', 3, 1)->nullable();
            $table->float('length', 8, 4)->nullable();
            $table->float('daily_fluid_production', 8, 2)->nullable();
            $table->float('bsw', 8, 2)->nullable();
            $table->float('gas_factor', 5, 2)->nullable();
            $table->float('pressure_start', 8, 4)->nullable();
            $table->float('pressure_end', 8, 4)->nullable();
            $table->float('temperature_start', 8, 4)->nullable();
            $table->float('temperature_end', 8, 4)->nullable();
            $table->string('start_point')->nullable();
            $table->string('end_point')->nullable();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('oil_pipe_id')->nullable();
            $table->float('mix_speed_avg', 8, 6)->nullable();
            $table->float('fluid_speed', 8, 6)->nullable();
            $table->float('gaz_speed', 8, 6)->nullable();
            $table->string('flow_type')->nullable();
            $table->float('press_change', 8, 6)->nullable();
            $table->integer('break_qty')->nullable();
            $table->float('height_drop', 8, 4)->nullable();
            $table->timestamps();
        });

        Schema::table('reverse_calculations', function (Blueprint $table) {
            $table->foreign('oil_pipe_id')->references('id')->on('oil_pipes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reverse_calculations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBigdataWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bigdata_wells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamp('date_create');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('org');
            $table->unsignedBigInteger('geo');
            $table->string('altitude')->nullable();
            $table->string('rotor_table')->nullable();
            $table->string('coord_type')->nullable();
            $table->string('coord_mouth_x')->nullable();
            $table->string('coord_mouth_y')->nullable();
            $table->unsignedBigInteger('type');
            $table->string('coord_bottom_x')->nullable();
            $table->string('coord_bottom_y')->nullable();
            $table->timestamp('date_start_drilling')->nullable();
            $table->timestamp('date_end_drilling')->nullable();
            $table->unsignedBigInteger('company')->nullable();
            $table->string('agreement_num');
            $table->timestamp('agreement_date');
            $table->string('planned_depth')->nullable();
            $table->string('avg_gasoil_ratio')->nullable();
            $table->string('planned_liquid_rate')->nullable();
            $table->string('planned_watering')->nullable();
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
        Schema::dropIfExists('bigdata_wells');
    }
}

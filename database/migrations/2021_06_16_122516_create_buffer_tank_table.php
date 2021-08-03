<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBufferTankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buffer_tank', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('field')->nullable();
            $table->bigInteger('ngdu_id')->unsigned()->nullable();
            $table->bigInteger('cdng_id')->unsigned()->nullable();
            $table->bigInteger('gu_id')->unsigned()->nullable();
            $table->string('model')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->float('volume')->nullable();
            $table->date('date_of_exploitation')->nullable();
            $table->string('current_state')->nullable();
            $table->date('external_and_internal_inspection')->nullable();
            $table->date('hydraulic_test')->nullable();
            $table->date('date_of_repair')->nullable();
            $table->string('type_of_repair')->nullable();
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
        Schema::dropIfExists('buffer_tank');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePumpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pumps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ngdu_id')->unsigned()->nullable();
            $table->bigInteger('gu_id')->unsigned()->nullable();
            $table->string('number')->nullable();
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->float('perfomance')->nullable();
            $table->float('power')->nullable();
            $table->date('date_of_exploitation')->nullable();
            $table->string('current_state')->nullable();
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
        Schema::dropIfExists('pumps');
    }
}

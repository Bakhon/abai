<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePipePassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipe_passports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('field')->nullable();
            $table->string('ngdu')->nullable();
            $table->string('gu')->nullable();
            $table->string('cdng')->nullable();
            $table->string('name')->nullable();
            $table->string('main_reserved')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('length')->nullable();
            $table->string('diameter')->nullable();
            $table->string('thickness')->nullable();
            $table->string('material')->nullable();
            $table->date('installation_date')->nullable();
            $table->string('condition')->nullable();
            $table->integer('gusts')->nullable();
            $table->tinyInteger('data_sheet')->nullable();
            $table->tinyInteger('used')->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('pipe_passports');
    }
}

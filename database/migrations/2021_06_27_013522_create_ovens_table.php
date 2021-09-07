<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ovens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gu_id')->unsigned()->nullable();
            $table->string('cipher')->nullable();
            $table->string('type')->nullable();
            $table->string('rated_heat_output')->nullable();
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
        Schema::dropIfExists('ovens');
    }
}

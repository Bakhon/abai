<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZuCleaningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zu_cleanings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('zu_id')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->integer('number_of_failures');
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
        Schema::dropIfExists('zu_cleanings');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuZuPipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gu_zu_pipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('zu_id')->unsigned()->nullable();
            $table->bigInteger('gu_id')->unsigned();
            $table->json('coordinates');
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
        Schema::dropIfExists('gu_pipes');
    }
}

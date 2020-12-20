<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZuWellPipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zu_well_pipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('well_id')->unsigned()->nullable();
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
        Schema::dropIfExists('zu_well_pipes');
    }
}

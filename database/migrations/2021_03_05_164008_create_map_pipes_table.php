<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapPipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_pipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->integer('ngdu_id')->nullable();
            $table->integer('gu_id')->nullable();
            $table->integer('zu_id')->nullable();
            $table->integer('well_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->string('between_points')->nullable();
            $table->string('comment')->nullable();
            $table->string('color')->nullable();
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
        Schema::dropIfExists('map_pipes');
    }
}

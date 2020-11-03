<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('gu_id');
            $table->float('length', 8, 4)->nullable();
            $table->float('outside_diameter', 8, 4)->nullable();
            $table->float('inner_diameter', 8, 4)->nullable();
            $table->float('thickness', 8, 4)->nullable();
            $table->float('roughness', 8, 4)->nullable();
            $table->integer('material_id');
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
        Schema::dropIfExists('pipes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmgCASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('omg_c_a_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('field')->nullable();
            $table->integer('ngdu_id')->nullable();
            $table->integer('cdng_id')->nullable();
            $table->integer('gu_id')->nullable();
            $table->integer('zu_id')->nullable();
            $table->integer('well_id')->nullable();
            $table->date('date');
            $table->float('plan_dosage', 8, 2)->nullable();
            $table->integer('cruser_id');
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
        Schema::dropIfExists('omg_c_a_s');
    }
}

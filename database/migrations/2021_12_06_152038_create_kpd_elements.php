<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpdElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpd_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kpd_id');
            $table->timestamps();
            $table->string("name")->nullable();
            $table->string("transcript")->nullable();
            $table->string("unit")->nullable();
            $table->string("source")->nullable();
            $table->string("responsible")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kpd_elements');
    }
}

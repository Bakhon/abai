<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpdFact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpd_fact', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kpd_id');
            $table->timestamps();
            $table->float("fact",32,8)->nullable();
            $table->string("comments")->nullable();
            $table->dateTime('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kpd_fact');
    }
}

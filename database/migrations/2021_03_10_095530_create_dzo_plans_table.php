<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDzoPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dzo_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date', 0);
            $table->text('dzo');
            $table->float('plan_oil',32,8)->nullable();
            $table->float('plan_kondensat',32,8)->nullable();
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
        Schema::dropIfExists('dzo_plans');
    }
}

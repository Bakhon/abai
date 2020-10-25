<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntiEcoTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anti_eco_twos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sc_fa');
            $table->integer('company_id');
            $table->integer('oil_cost');
            $table->integer('oil_cost_exp_one');
            $table->integer('oil_cost_exp_two');
            $table->integer('oil_cost_exp_three');
            $table->integer('oil_cost_ins_one');
            $table->integer('oil_cost_ins_two');
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
        Schema::dropIfExists('anti_eco_twos');
    }
}

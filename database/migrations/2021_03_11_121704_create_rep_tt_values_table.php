<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepTtValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rep_tt_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rep_id')->references('id')->on('rep_tt')->onDelete('cascade');
            $table->bigInteger('company_id')->references('id')->on('subholding_companies')->onDelete('cascade');
            $table->date('date');
            $table->string('value');
            $table->string('rep_tt')->nullable();
            $table->string('company')->nullable();
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
        Schema::dropIfExists('rep_tt_values');
    }
}

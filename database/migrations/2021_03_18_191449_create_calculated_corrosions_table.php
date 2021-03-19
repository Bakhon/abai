<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculatedCorrosionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculated_corrosions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('gu_id')->unsigned();
            $table->date('date');
            $table->float('corrosion',8,4);
            $table->timestamps();
        });

        Schema::table('calculated_corrosions', function (Blueprint $table) {
            $table->foreign('gu_id')->references('id')->on('gus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculated_corrosions');
    }
}

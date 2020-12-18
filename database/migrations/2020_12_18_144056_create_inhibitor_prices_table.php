<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInhibitorPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inhibitor_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inhibitor_id')->unsigned();
            $table->float('price');
            $table->datetime('date_from');
            $table->datetime('date_to')->nullable();

            $table->foreign('inhibitor_id')->references('id')->on('inhibitors')->onDelete('cascade');

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
        Schema::dropIfExists('inhibitor_prices');
    }
}

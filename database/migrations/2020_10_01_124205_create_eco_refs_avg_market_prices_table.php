<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsAvgMarketPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_avg_market_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('avg_market_price_id');
            $table->integer('exp_cust_duty_rate');
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
        Schema::dropIfExists('eco_refs_avg_market_prices');
    }
}

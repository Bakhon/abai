<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsRentTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_rent_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sc_fa');
            $table->integer('world_price_beg');
            $table->integer('world_price_end');
            $table->float('rate');
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
        Schema::dropIfExists('eco_refs_rent_taxes');
    }
}

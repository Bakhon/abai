<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsAnnualProdVolumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_annual_prod_volumes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('annual_prod_volume_id');
            $table->integer('annual_prod_volume_beg');
            $table->integer('annual_prod_volume_end');
            $table->float('ndpi',8,2);
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
        Schema::dropIfExists('eco_refs_annual_prod_volumes');
    }
}

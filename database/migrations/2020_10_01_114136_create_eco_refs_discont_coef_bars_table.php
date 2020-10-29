<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsDiscontCoefBarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_discont_coef_bars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sc_fa');
            $table->integer('company_id');
            $table->integer('direction_id');
            $table->integer('route_id');
            $table->date('date');
            $table->float('barr_coef',8,2);
            $table->float('discont',8,2);
            $table->float('oil_cost',8,2);
            $table->float('macro', 8,2);
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
        Schema::dropIfExists('eco_refs_discont_coef_bars');
    }
}

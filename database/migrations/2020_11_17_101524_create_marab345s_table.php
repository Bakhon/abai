<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarab345sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marab345s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('marabkpi_id');
            $table->integer('type_id');
            $table->date('date');
            // $table->text('__time');
            $table->integer('fact_zatraty_na_sebestoimost_dobychi_nefti')->nullable();
            $table->integer('fact_zatraty_kapitalnogo_vlozhenia')->nullable();
            $table->integer('opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov')->nullable();
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
        Schema::dropIfExists('marab345s');
    }
}

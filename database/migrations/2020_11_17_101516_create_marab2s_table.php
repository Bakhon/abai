<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarab2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marab2s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('type_id');
            $table->date('date_col');
            $table->integer('dividends');
            $table->integer('vklad_v_ustavnoy_kapital');
            $table->integer('vydacha_zaimov');
            $table->integer('vozvrat_zaimov');
            $table->integer('vozvrat_ustavnogo_kapitala');
            $table->integer('others');
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
        Schema::dropIfExists('marab2s');
    }
}

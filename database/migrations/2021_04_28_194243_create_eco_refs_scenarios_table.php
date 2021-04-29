<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsScenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_scenarios', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('sc_fa_id');
            $table->foreign('sc_fa_id')
                ->references('id')
                ->on('eco_refs_sc_fas');

            $table->string('name');

            $table->json('params');

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
        Schema::dropIfExists('eco_refs_scenarios');
    }
}

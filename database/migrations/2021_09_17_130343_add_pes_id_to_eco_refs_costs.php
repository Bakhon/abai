<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPesIdToEcoRefsCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_costs', function (Blueprint $table) {
            $table->unsignedBigInteger('pes_id')->nullable();
            $table->foreign('pes_id')
                ->references('id')
                ->on('technical_structure_pes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_costs', function (Blueprint $table) {
            $table->dropForeign(['pes_id']);
            $table->dropColumn(['pes_id']);
        });
    }
}

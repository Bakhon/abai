<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScFaDateIndexToEcoRefsCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_costs', function (Blueprint $table) {
            $table->index(["sc_fa", "date"], "eco_refs_cost_sc_fa_date_index");
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
            $table->dropIndex("eco_refs_cost_sc_fa_date_index");
        });
    }
}

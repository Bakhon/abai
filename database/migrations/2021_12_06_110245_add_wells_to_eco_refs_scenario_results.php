<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWellsToEcoRefsScenarioResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_scenario_results', function (Blueprint $table) {
            $table->json('wells')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_scenario_results', function (Blueprint $table) {
            $table->dropColumn(['wells']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPermanentStopCostToEcoRefsAnalysisParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_analysis_params', function (Blueprint $table) {
            $table->dropColumn(['permanent_stop_cost']);

            $table->dropColumn(['permanent_stop_cost_propose']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_analysis_params', function (Blueprint $table) {
            $table->float('permanent_stop_cost', 12, 2);

            $table->float('permanent_stop_cost_propose', 12, 2);
        });
    }
}

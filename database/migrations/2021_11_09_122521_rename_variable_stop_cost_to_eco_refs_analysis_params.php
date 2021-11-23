<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameVariableStopCostToEcoRefsAnalysisParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_analysis_params', function (Blueprint $table) {
            $table->renameColumn('variable_stop_cost_fact', 'permanent_stop_cost');

            $table->renameColumn('variable_stop_cost_forecast', 'permanent_stop_cost_propose');
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
            $table->renameColumn('permanent_stop_cost', 'variable_stop_cost_fact');

            $table->renameColumn('permanent_stop_cost_propose', 'variable_stop_cost_forecast');
        });
    }
}

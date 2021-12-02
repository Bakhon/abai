<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDimensionToEcoRefsAnalysisParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_analysis_params', function (Blueprint $table) {
            $table->float('netback_plan', 24, 12)->change();
            $table->float('netback_fact', 24, 12)->change();
            $table->float('netback_forecast', 24, 12)->change();

            $table->float('variable_cost', 24, 12)->change();
            $table->float('permanent_cost', 24, 12)->change();
            $table->float('permanent_year_cost', 24, 12)->change();
            $table->float('avg_prs_cost', 24, 12)->change();

            $table->float('oil_density', 14, 12)->change();

            $table->float('variable_stop_cost_fact', 24, 12)->change();
            $table->float('variable_stop_cost_forecast', 24, 12)->change();
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
            $table->float('netback_plan', 12, 2)->change();
            $table->float('netback_fact', 12, 2)->change();
            $table->float('netback_forecast', 12, 2)->change();

            $table->float('variable_cost', 12, 2)->change();
            $table->float('permanent_cost', 12, 2)->change();
            $table->float('permanent_year_cost', 12, 2)->change();
            $table->float('avg_prs_cost', 12, 2)->change();

            $table->float('oil_density', 12, 2)->change();

            $table->float('variable_stop_cost_fact', 12, 2)->change();
            $table->float('variable_stop_cost_forecast', 12, 2)->change();
        });
    }
}

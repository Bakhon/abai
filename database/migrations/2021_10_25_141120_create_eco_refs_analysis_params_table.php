<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsAnalysisParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_analysis_params', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('log_id');
            $table->foreign('log_id')
                ->references('id')
                ->on('economic_data_logs');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->date('date');

            $table->float('netback_plan', 12, 2);
            $table->float('netback_fact', 12, 2);
            $table->float('netback_forecast', 12, 2);
            $table->float('variable_cost', 12, 2);
            $table->float('permanent_cost', 12, 2);
            $table->float('permanent_year_cost', 12, 2);
            $table->float('avg_prs_cost', 12, 2);
            $table->float('oil_density', 12, 2);

            $table->unsignedInteger('days');

            $table->float('variable_stop_cost_fact', 12, 2);
            $table->float('variable_stop_cost_forecast', 12, 2);

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
        Schema::dropIfExists('eco_refs_analysis_params');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsScenarioResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_scenario_results', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('scenario_id');
            $table->foreign('scenario_id')
                ->references('id')
                ->on('eco_refs_scenarios');

            $table->unsignedInteger('oil_price');
            $table->unsignedInteger('dollar_rate');

            $table->json('variants');

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
        Schema::dropIfExists('eco_refs_scenario_results');
    }
}

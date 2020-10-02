<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsPrepElectPrsBrigCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_prep_elect_prs_brig_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->date('date');
            $table->integer('elect_cost');
            $table->integer('trans_prep_cost');
            $table->integer('prs_brigade_cost');
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
        Schema::dropIfExists('eco_refs_prep_elect_prs_brig_costs');
    }
}

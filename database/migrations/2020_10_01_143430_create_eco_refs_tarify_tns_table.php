<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsTarifyTnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_tarify_tns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sc_fa');
            $table->integer('branch_id');
            $table->integer('company_id');
            $table->integer('direction_id');
            $table->integer('route_tn_id');
            $table->date('date');
            $table->float('tn_rate',8,2);
            $table->float('extent',8,2);
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
        Schema::dropIfExists('eco_refs_tarify_tns');
    }
}

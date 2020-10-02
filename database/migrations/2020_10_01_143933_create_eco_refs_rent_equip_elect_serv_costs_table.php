<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsRentEquipElectServCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_rent_equip_elect_serv_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('equip_id');
            $table->date('date');
            $table->integer('rent_cost');
            $table->integer('equip_cost');
            $table->integer('elect_cons');
            $table->integer('dayli_serv_cost');
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
        Schema::dropIfExists('eco_refs_rent_equip_elect_serv_costs');
    }
}

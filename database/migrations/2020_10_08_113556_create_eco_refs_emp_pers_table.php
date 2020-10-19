<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsEmpPersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_emp_pers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sc_fa');
            $table->integer('company_id');
            $table->integer('direction_id');
            $table->integer('route_id');
            $table->date('date');
            $table->float('emp_per',8,4);
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
        Schema::dropIfExists('eco_refs_emp_pers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmgUHESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('omg_u_h_e_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('field')->nullable();
            $table->integer('ngdu_id')->nullable();
            $table->integer('cdng_id')->nullable();
            $table->integer('gu_id')->nullable();
            $table->integer('zu_id')->nullable();
            $table->integer('well_id')->nullable();
            $table->date('date');
            $table->float('current_dosage', 8, 4)->nullable();
            $table->float('level', 8, 4)->nullable();
            $table->float('fill', 8, 4)->nullable();
            $table->float('daily_inhibitor_flowrate', 8, 4)->nullable();
            $table->float('monthly_inhibitor_flowrate', 8, 4)->nullable();
            $table->float('out_of_service_of_dosing', 8, 4)->nullable();
            $table->longText('reason')->nullable();
            $table->integer('cruser_id');
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
        Schema::dropIfExists('omg_u_h_e_s');
    }
}

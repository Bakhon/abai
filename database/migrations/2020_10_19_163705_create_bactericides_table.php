<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBactericidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bactericides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('other_objects_id')->nullable();
            $table->date('start_date_of_injection');
            $table->date('final_date_of_injection');
            $table->float('shock_injection_bactericide_flowrate', 8, 4)->nullable();
            $table->float('constant_injection_bactericide_flowrate', 8, 4)->nullable();
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
        Schema::dropIfExists('bactericides');
    }
}

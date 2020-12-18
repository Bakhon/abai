<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarab6sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marab6s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type_id');	
            $table->date('aim_dates')->nullable();
            $table->integer('remained_days')->nullable();
            $table->float('completion_probability',8,4)->nullable();
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
        Schema::dropIfExists('marab6s');
    }
}

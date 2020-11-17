<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbd12sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abd12s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('abdkpi_id');
            $table->integer('type_id');
            // $table->date('date_col');
            $table->integer('aim_params');
            // $table->integer('fact');
            $table->integer('remaining_days');
            $table->float('expactations_percentage', 8, 4);
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
        Schema::dropIfExists('abd12s');
    }
}

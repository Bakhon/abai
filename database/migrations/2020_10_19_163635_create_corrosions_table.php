<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrosionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corrosions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('field')->nullable();
            $table->integer('ngdu_id')->nullable();
            $table->integer('cdng_id')->nullable();
            $table->integer('gu_id')->nullable();
            $table->date('start_date_of_background_corrosion');
            $table->date('final_date_of_background_corrosion');
            $table->float('background_corrosion_velocity', 8, 4)->nullable();
            $table->date('start_date_of_corrosion_velocity_with_inhibitor_measure');
            $table->date('final_date_of_corrosion_velocity_with_inhibitor_measure');
            $table->float('corrosion_velocity_with_inhibitor', 8, 4)->nullable();
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
        Schema::dropIfExists('corrosions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEconomicalEffectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('economical_effects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gu_id')->unsigned()->nullable();
            $table->date('date');
            $table->float('сorrosion')->nullable();
            $table->float('actual_inhibitor_injection')->nullable();
            $table->float('recommended_inhibitor_injection')->nullable();
            $table->float('difference')->nullable();
            $table->float('inhibitor_price')->nullable();
            $table->float('economical_effect')->nullable();
            $table->float('economical_effect_sum')->nullable();
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
        Schema::dropIfExists('economical_effects');
    }
}

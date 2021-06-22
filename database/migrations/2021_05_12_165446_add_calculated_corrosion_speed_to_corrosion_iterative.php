<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCalculatedCorrosionSpeedToCorrosionIterative extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corrosion_iterative', function (Blueprint $table) {
            $table->float('calculated_corrosion_speed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corrosion_iterative', function (Blueprint $table) {
            $table->dropColumn(['calculated_corrosion_speed']);
        });
    }
}

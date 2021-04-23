<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEndPointColumnTrunklinePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trunkline_points', function (Blueprint $table) {
            $table->dropColumn('end_point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trunkline_points', function (Blueprint $table) {
            $table->string('end_point')->nullable();
        });
    }
}

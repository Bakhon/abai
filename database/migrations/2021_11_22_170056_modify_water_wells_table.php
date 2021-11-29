<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyWaterWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('water_wells', function (Blueprint $table) {
            $table->dropColumn('length');
            $table->dropColumn('point_x');
            $table->dropColumn('point_y');
            $table->dropColumn('object_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('water_wells', function (Blueprint $table) {
            $table->bigInteger('object_id')->nullable();
            $table->float('length', 13, 7)->nullable();
            $table->float('point_x', 12, 4)->nullable();
            $table->float('point_y', 12, 4)->nullable();
        });
    }
}

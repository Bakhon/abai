<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsTypeLatLonElevationFromVarcharToFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gus', function (Blueprint $table) {
            $table->float('elevation', 6, 2)->change();
            $table->float('lat', 12, 10)->change();
            $table->float('lon', 12, 10)->change();
        });

        Schema::table('zus', function (Blueprint $table) {
            $table->float('elevation', 6, 2)->change();
            $table->float('lat', 12, 10)->change();
            $table->float('lon', 12, 10)->change();
        });

        Schema::table('wells', function (Blueprint $table) {
            $table->float('elevation', 6, 2)->change();
            $table->float('lat', 12, 10)->change();
            $table->float('lon', 12, 10)->change();
        });

        Schema::table('trunkline_points', function (Blueprint $table) {
            $table->float('elevation', 6, 2)->change();
            $table->float('lat', 12, 10)->change();
            $table->float('lon', 12, 10)->change();
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
            $table->string('lat')->change();
            $table->string('lon')->change();
        });

        Schema::table('gus', function (Blueprint $table) {
            $table->string('elevation')->change();
            $table->string('lat')->change();
            $table->string('lon')->change();
        });

        Schema::table('zus', function (Blueprint $table) {
            $table->string('elevation')->change();
            $table->string('lat')->change();
            $table->string('lon')->change();
        });

        Schema::table('wells', function (Blueprint $table) {
            $table->string('elevation')->change();
            $table->string('lat')->change();
            $table->string('lon')->change();
        });
    }
}

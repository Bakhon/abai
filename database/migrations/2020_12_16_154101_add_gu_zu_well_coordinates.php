<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuZuWellCoordinates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gus', function (Blueprint $table) {
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
        });

        Schema::table('zus', function (Blueprint $table) {
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
        });

        Schema::table('wells', function (Blueprint $table) {
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gus', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lon');
        });

        Schema::table('zus', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lon');
        });

        Schema::table('wells', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lon');
        });
    }
}

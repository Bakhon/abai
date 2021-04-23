<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointColumnsToMapPipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_pipes', function (Blueprint $table) {
            $table->string('start_point')->nullable();
            $table->string('end_point')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_pipes', function (Blueprint $table) {
            $table->dropColumn('start_point', 'end_point');
        });
    }
}

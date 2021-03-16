<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddElevationColumnZusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zus', function (Blueprint $table) {
            $table->string('elevation')->nullable();
            $table->integer('ngdu_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zus', function (Blueprint $table) {
            $table->dropColumn('elevation', 'ngdu_id');
        });
    }
}

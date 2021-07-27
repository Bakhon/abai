<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNgduIdBufferTank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buffer_tank', function (Blueprint $table) {
            $table->dropColumn('ngdu_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buffer_tank', function (Blueprint $table) {
            $table->bigInteger('ngdu_id')->unsigned()->nullable();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVolumeTypeBufferTank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buffer_tank', function (Blueprint $table) {
            $table->integer('volume')->nullable()->change();
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
            $table->float('volume')->nullable()->change();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogIdToEcoRefsGtms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_gtms', function (Blueprint $table) {
            $table->unsignedBigInteger('log_id')->nullable();
            $table->foreign('log_id')
                ->references('id')
                ->on('economic_data_logs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_gtms', function (Blueprint $table) {
            $table->dropForeign(['log_id']);
            $table->dropColumn(['log_id']);
        });
    }
}

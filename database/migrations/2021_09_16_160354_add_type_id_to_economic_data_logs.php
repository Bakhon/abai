<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeIdToEconomicDataLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('economic_data_logs', function (Blueprint $table) {
           $table->unsignedTinyInteger('type_id')->nullable();

            $table->foreign('type_id')
                ->references('id')
                ->on('economic_data_log_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('economic_data_logs', function (Blueprint $table) {
            $table->dropForeign(['type_id']);

            $table->dropColumn(['type_id']);
        });
    }
}

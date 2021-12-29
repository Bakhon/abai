<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManufacturingProgramLogIdToEcoRefsScenarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_scenarios', function (Blueprint $table) {
            $table->unsignedBigInteger('manufacturing_program_log_id')->nullable();
            $table->foreign('manufacturing_program_log_id')
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
        Schema::table('eco_refs_scenarios', function (Blueprint $table) {
           $table->dropForeign(['manufacturing_program_log_id']);
           $table->dropColumn(['manufacturing_program_log_id']);
        });
    }
}

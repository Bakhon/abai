<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGtmLogIdToEcoRefsScenarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_scenarios', function (Blueprint $table) {
            $table->unsignedBigInteger('gtm_kit_id')->nullable();
            $table->foreign('gtm_kit_id')
                ->references('id')
                ->on('eco_refs_gtm_kits');
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
            $table->dropForeign(['gtm_kit_id']);
            $table->dropColumn(['gtm_kit_id']);
        });
    }
}

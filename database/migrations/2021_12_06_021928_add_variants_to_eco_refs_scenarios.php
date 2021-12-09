<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariantsToEcoRefsScenarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_scenarios', function (Blueprint $table) {
            $table->unsignedInteger('total_variants')->nullable();

            $table->unsignedInteger('calculated_variants')->nullable();
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
            $table->dropColumn(['total_variants', 'calculated_variants']);
        });
    }
}

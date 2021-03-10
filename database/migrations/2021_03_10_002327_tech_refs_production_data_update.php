<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TechRefsProductionDataUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tech_refs_production_data', function (Blueprint $table) {
            $table->string('comment')->nullable();
            $table->unique(['well_id', 'date'], 'well_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tech_refs_production_data', function (Blueprint $table) {
            $table->dropUnique('well_date');
            $table->dropColumn(['comment']);
        });
    }
}

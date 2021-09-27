<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueKeyToEcoRefsCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_costs', function (Blueprint $table) {
            $table->dropForeign(['sc_fa']);

            $table->dropForeign(['company_id']);

            $table->dropUnique('sc_company_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_costs', function (Blueprint $table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('eco_refs_companies_ids');

            $table->foreign('sc_fa')
                ->references('id')
                ->on('eco_refs_sc_fas');

            $table->unique(['sc_fa', 'company_id', 'date'], 'sc_company_date');
        });
    }
}

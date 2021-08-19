<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueToEcoRefsGtms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_gtms', function (Blueprint $table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('eco_refs_companies_ids');

            $table->unique(['company_id', 'name'], 'unique_company_id_name');
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
            $table->dropForeign(['company_id']);

            $table->dropUnique('unique_company_id_name');
        });
    }
}

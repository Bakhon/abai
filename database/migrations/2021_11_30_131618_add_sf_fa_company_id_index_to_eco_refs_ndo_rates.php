<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSfFaCompanyIdIndexToEcoRefsNdoRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_ndo_rates', function (Blueprint $table) {
            $table->unsignedBigInteger('sc_fa')->change();

            $table->index(
                ["sc_fa", "company_id"],
                "eco_refs_ndo_rates_sc_fa_company_id_index"
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_ndo_rates', function (Blueprint $table) {
            $table->dropIndex('eco_refs_ndo_rates_sc_fa_company_id_index');
        });
    }
}

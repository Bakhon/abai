<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSfFaDateIndexToEcoRefsMacros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_macros', function (Blueprint $table) {
            $table
                ->unsignedBigInteger('sc_fa')
                ->change();

            $table->index(['sc_fa', 'date'], 'eco_refs_macros_sc_fa_date_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_macros', function (Blueprint $table) {
            $table->dropIndex('eco_refs_macros_sc_fa_date_index');
        });
    }
}

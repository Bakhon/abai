<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EcorefsmacroAddWorldPriceBarrel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_macros', function($table) {
            $table->integer('ex_rate_dol')->nullable()->change();
            $table->integer('ex_rate_rub')->nullable()->change();
            $table->float('inf_end')->nullable()->change();
            $table->float("barrel_world_price", 6, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_macros', function($table) {
            $table->dropColumn("barrel_world_price");
        });
    }
}

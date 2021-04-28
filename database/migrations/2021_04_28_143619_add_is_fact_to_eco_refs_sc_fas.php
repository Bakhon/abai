<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFactToEcoRefsScFas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_sc_fas', function (Blueprint $table) {
            $table->boolean('is_fact')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_sc_fas', function (Blueprint $table) {
            $table->dropColumn(['is_fact']);
        });
    }
}

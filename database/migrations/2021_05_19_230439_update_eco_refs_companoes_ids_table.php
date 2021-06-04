<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEcoRefsCompanoesIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_companies_ids', function (Blueprint $table) {
            $table->string('num')->after('id');
            $table->integer('level')->after('name');
            $table->integer('parent_id')->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_refs_companies_ids', function (Blueprint $table) {
            $table->dropColumn(['num']);
            $table->dropColumn(['level']);
            $table->dropColumn(['parent_id']);
        });
    }
}

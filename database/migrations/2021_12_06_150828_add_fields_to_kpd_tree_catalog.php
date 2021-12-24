<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToKpdTreeCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kpd_tree_catalog', function (Blueprint $table) {
        $table->dropColumn(
            'variables',
            'polarity',
            'source',
        );
            $table->string("result")->nullable();
            $table->string("type")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kpd_tree_catalog', function (Blueprint $table) {
            $table->dropColumn(
                'result',
            );
        });
    }
}

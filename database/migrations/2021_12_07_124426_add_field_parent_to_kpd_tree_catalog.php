<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldParentToKpdTreeCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kpd_tree_catalog', function (Blueprint $table) {
            $table->string("parent")->nullable();
            $table->string("description_document")->nullable();
            $table->string("calculation_document")->nullable();
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
                'parent',
            );
        });
    }
}

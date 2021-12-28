<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeightToKpdTreeCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kpd_tree_catalog', function (Blueprint $table) {
            $table->float("weight",32,8)->nullable();
            $table->text('name')->change();
            $table->text('description')->change();
            $table->text('unit')->change();
            $table->text('formula')->change();
            $table->text('responsible')->change();
            $table->text('functions')->change();
            $table->text('type')->change();
            $table->text('result')->change();
            $table->text('parent')->change();
            $table->text('description_document')->change();
            $table->text('calculation_document')->change();
        });
        Schema::table('kpd_elements', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('transcript')->change();
            $table->text('unit')->change();
            $table->text('source')->change();
            $table->text('responsible')->change();
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
                'weight'
            );
        });
    }
}

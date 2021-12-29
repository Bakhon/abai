<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeAtKpdTreeCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kpd_tree_catalog', function (Blueprint $table) {
            $table->string('step')->nullable()->change();
            $table->string('target')->nullable()->change();
            $table->string('maximum')->nullable()->change();
            $table->string('weight')->nullable()->change();
        });
        Schema::table('kpd_tree_catalog', function (Blueprint $table) {
            $table->string('step')->nullable()->change();
            $table->string('target')->nullable()->change();
            $table->string('maximum')->nullable()->change();
            $table->string('weight')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequiredFieldsInPipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pipes', function (Blueprint $table) {
            $table->float('length', 8, 4)->nullable(false)->change();
            $table->float('outside_diameter', 8, 4)->nullable(false)->change();
            $table->float('roughness', 8, 4)->nullable(false)->change();
            $table->integer('material_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pipes', function (Blueprint $table) {
            $table->float('length', 8, 4)->nullable()->change();
            $table->float('outside_diameter', 8, 4)->nullable()->change();
            $table->float('roughness', 8, 4)->nullable()->change();
            $table->integer('material_id')->nullable(false)->change();
        });
    }
}

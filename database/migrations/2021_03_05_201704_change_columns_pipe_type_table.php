<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsPipeTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pipe_types', function (Blueprint $table) {
            $table->float('outside_diameter', 8, 4)->nullable()->change();
            $table->float('inner_diameter', 8, 4)->nullable()->change();
            $table->float('thickness', 8, 4)->nullable()->change();
            $table->float('roughness', 8, 4)->nullable()->change();
            $table->bigInteger('material_id')->nullable()->change();
            $table->string('plot', 10)->nullable()->change();
            $table->string('name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gus', function (Blueprint $table) {
            $table->float('outside_diameter', 8, 4)->change();
            $table->float('inner_diameter', 8, 4)->change();
            $table->float('thickness', 8, 4)->change();
            $table->float('roughness', 8, 4)->change();
            $table->bigInteger('material_id')->change();
            $table->string('plot', 10)->change();
            $table->string('name')->change();
        });
    }
}

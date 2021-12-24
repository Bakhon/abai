<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanFieldsToKpdTreeController extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kpd_tree_catalog', function (Blueprint $table) {
            $table->float("step",32,8)->nullable();
            $table->float("target",32,8)->nullable();
            $table->float("maximum",32,8)->nullable();
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
                'step',
                'target',
                'maximum'
            );
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SgOilExtendPrecision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_n_g_d_u_zus', function (Blueprint $table) {
            $table->float("sg_oil",6,4)->nullable()->change();
            $table->float("sg_gas",6,4)->nullable()->change();
            $table->float("sg_water",6,4)->nullable()->change();
        });

        Schema::table('omg_n_g_d_u_wells', function (Blueprint $table) {
            $table->float("sg_oil",6,4)->nullable()->change();
            $table->float("sg_gas",6,4)->nullable()->change();
            $table->float("sg_water",6,4)->nullable()->change();
        });

        Schema::table('omg_n_g_d_u_s_1', function (Blueprint $table) {
            $table->float("sg_oil",6,4)->nullable()->change();
            $table->float("sg_gas",6,4)->nullable()->change();
            $table->float("sg_water",6,4)->nullable()->change();
        });

        DB::table('omg_n_g_d_u_wells')
            ->where('sg_oil', 0.86)
            ->update([
                'sg_oil' => 0.85,
                'sg_gas' => 0.79,
                'sg_water' => 1.046,
            ]);

        DB::table('omg_n_g_d_u_wells')
            ->where('sg_oil', 0.86)
            ->update([
                'sg_oil' => 0.85,
                'sg_gas' => 0.79,
                'sg_water' => 1.046,
            ]);

        DB::table('omg_n_g_d_u_wells')
            ->where('sg_oil', 0.86)
            ->update([
                'sg_oil' => 0.85,
                'sg_gas' => 0.79,
                'sg_water' => 1.046,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_n_g_d_u_zus', function (Blueprint $table) {
            $table->float("sg_oil",4,2)->nullable()->change();
            $table->float("sg_gas",4,2)->nullable()->change();
            $table->float("sg_water",4,2)->nullable()->change();
        });

        Schema::table('omg_n_g_d_u_wells', function (Blueprint $table) {
            $table->float("sg_oil",4,2)->nullable()->change();
            $table->float("sg_gas",4,2)->nullable()->change();
            $table->float("sg_water",4,2)->nullable()->change();
        });

        Schema::table('omg_n_g_d_u_s_1', function (Blueprint $table) {
            $table->float("sg_oil",4,2)->nullable()->change();
            $table->float("sg_gas",4,2)->nullable()->change();
            $table->float("sg_water",4,2)->nullable()->change();
        });
    }
}

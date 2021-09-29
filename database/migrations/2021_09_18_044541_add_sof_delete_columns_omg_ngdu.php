<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSofDeleteColumnsOmgNgdu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_n_g_d_u_s_1', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('omg_n_g_d_u_wells', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('omg_n_g_d_u_zus', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_n_g_d_u_s_1', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('omg_n_g_d_u_wells', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('omg_n_g_d_u_zus', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParamsOmgNgduTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_n_g_d_u_s_1', function (Blueprint $table) {
            $table->float("sg_oil",4,2)->nullable();
            $table->float("sg_gas",4,2)->nullable();
            $table->float("sg_water",4,2)->nullable();
        });

        DB::table('omg_n_g_d_u_s_1')
            ->update([
                'sg_oil' => 0.86,
                'sg_gas' => 0.75,
                'sg_water' => 1.03,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_n_g_d_u_s_1', function (Blueprint $table) {
            $table->dropColumn('sg_oil', 'sg_gas', 'sg_water');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OmgNgduTableDropIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_n_g_d_u_s_1', function (Blueprint $table) {
            $table->dropIndex('omg_n_g_d_u_s_1_gu_id_foreign');
            $table->dropIndex('omg_n_g_d_u_s_1_zu_id_foreign');
        });

        DB::statement("ALTER TABLE omg_n_g_d_u_s_1 DROP FOREIGN KEY omg_n_g_d_u_s_1_well_id_foreign");
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

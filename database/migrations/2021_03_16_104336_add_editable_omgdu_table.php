<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditableOmgduTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_n_g_d_u_s', function (Blueprint $table) {
            $table->tinyInteger('editable')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_n_g_d_u_s', function (Blueprint $table) {
            $table->dropColumn('editable');
        });
    }
}

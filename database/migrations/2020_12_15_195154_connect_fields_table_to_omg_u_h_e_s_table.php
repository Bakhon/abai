<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectFieldsTableToOmgUHESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_u_h_e_s', function (Blueprint $table) {
            $table->renameColumn('field', 'field_id');
        });
        Schema::table('omg_u_h_e_s', function (Blueprint $table) {
            $table->bigInteger('field_id')->unsigned()->change();
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_u_h_e_s', function (Blueprint $table) {
            $table->renameColumn('field_id', 'field');

            $table->dropForeign('omg_u_h_e_s_field_id_foreign');
            $table->dropIndex('omg_u_h_e_s_field_id_foreign');
        });
    }
}

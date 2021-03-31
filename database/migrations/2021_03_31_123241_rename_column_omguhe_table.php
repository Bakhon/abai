<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnOmguheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_u_h_e_s', function (Blueprint $table) {
            $table->renameColumn('out_of_service_оf_dosing', 'out_of_service_of_dosing');
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
            $table->renameColumn('out_of_service_of_dosing', 'out_of_service_оf_dosing');
        });
    }
}

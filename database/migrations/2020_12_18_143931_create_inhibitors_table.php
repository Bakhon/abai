<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInhibitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inhibitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('omg_u_h_e_s', function (Blueprint $table) {
            $table->bigInteger('inhibitor_id')->unsigned()->nullable();
            $table->foreign('inhibitor_id')->references('id')->on('inhibitors')->onDelete('set null');
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
            $table->dropForeign('omg_u_h_e_s_inhibitor_id_foreign');
            $table->dropIndex('omg_u_h_e_s_inhibitor_id_foreign');
            $table->dropColumn('inhibitor_id');
        });

        Schema::dropIfExists('inhibitors');
    }
}

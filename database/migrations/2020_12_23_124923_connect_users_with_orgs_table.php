<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectUsersWithOrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'users',
            function ($table) {
                $table->bigInteger('org_id')->unsigned()->nullable();
                $table->foreign('org_id')->references('id')->on('orgs')->onDelete('set null');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'users',
            function ($table) {
                $table->dropForeign('users_org_id_foreign');
                $table->dropIndex('users_org_id_foreign');
                $table->dropColumn('org_id');
            }
        );
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsZuCleanings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zu_cleanings', function (Blueprint $table) {
            $table->bigInteger('gu_id')->unsigned()->nullable();
            $table->string('failure_reason')->nullable();
            $table->string('repair_period')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zu_cleanings', function (Blueprint $table) {
            $table->dropColumn(['gu_id', 'failure_reason', 'repair_period']);
        });

    }
}

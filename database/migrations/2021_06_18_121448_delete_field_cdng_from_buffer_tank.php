<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFieldCdngFromBufferTank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buffer_tank', function (Blueprint $table) {
            $table->dropColumn(['field', 'cdng_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buffer_tank', function (Blueprint $table) {
            $table->string('field')->nullable();
            $table->bigInteger('cdng_id')->unsigned()->nullable();
        });
    }
}

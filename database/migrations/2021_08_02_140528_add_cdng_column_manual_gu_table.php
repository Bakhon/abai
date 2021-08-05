<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCdngColumnManualGuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manual_gus', function (Blueprint $table) {
            $table->unsignedBigInteger('cdng_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manual_gus', function (Blueprint $table) {
                $table->dropColumn('cdng_id');
            });
    }
}

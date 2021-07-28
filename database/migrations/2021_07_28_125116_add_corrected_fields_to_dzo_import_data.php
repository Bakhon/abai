<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCorrectedFieldsToDzoImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_data', function (Blueprint $table) {
            $table->boolean('is_corrected')->nullable();
            $table->boolean('is_approved')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_import_data', function (Blueprint $table) {
            $table->dropColumn(
                'is_corrected',
                'is_approved'
            );
        });
    }
}

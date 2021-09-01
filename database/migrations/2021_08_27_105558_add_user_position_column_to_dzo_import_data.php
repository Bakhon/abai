<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserPositionColumnToDzoImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_data', function (Blueprint $table) {
            $table->text('user_position')->nullable();
            $table->timestamps();
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
                'user_position'
            );
        });
    }
}

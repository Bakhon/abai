<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToOilPipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oil_pipes', function (Blueprint $table) {
            // $table->string('name');
            $table->string('main/reserved');
            // $table->string('material');
            $table->string('installation_date');
            $table->string('pipe_condition');
            $table->integer('number_of_gusts');
            $table->string('availability_of_data_sheet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oil_pipes', function (Blueprint $table) {
            $table->dropColumn(['main/reserved', 'installation_date', 'pipe_condition', 'number_of_gusts', 'availability_of_data_sheet']);
        });
    }
}

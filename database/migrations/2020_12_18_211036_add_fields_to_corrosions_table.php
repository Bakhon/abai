<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCorrosionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corrosions', function (Blueprint $table) {
            $table->string('sample_number')->nullable();
            $table->float('weight_before')->nullable();
            $table->float('weight_after')->nullable();
            $table->integer('days')->nullable();
            $table->float('avg_speed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corrosions', function (Blueprint $table) {
            $table->dropColumn('sample_number');
            $table->dropColumn('weight_before');
            $table->dropColumn('weight_after');
            $table->dropColumn('days');
            $table->dropColumn('avg_speed');
        });
    }
}

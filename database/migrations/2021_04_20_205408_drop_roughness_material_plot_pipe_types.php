<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropRoughnessMaterialPlotPipeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pipe_types', function (Blueprint $table) {
            $table->dropColumn(['roughness', 'plot']);
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pipe_types', function (Blueprint $table) {
            $table->float('roughness', 8, 4)->nullable();
            $table->char('plot',10);
          });
    }
}

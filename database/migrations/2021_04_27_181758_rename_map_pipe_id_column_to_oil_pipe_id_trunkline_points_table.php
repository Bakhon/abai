<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMapPipeIdColumnToOilPipeIdTrunklinePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trunkline_points', function(Blueprint $table) {
            $table->renameColumn('map_pipe_id', 'oil_pipe_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trunkline_points', function (Blueprint $table) {
            $table->renameColumn('oil_pipe_id', 'map_pipe_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTrunklineTableForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trunkline_points', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('trunkline_points');

            if ($doctrineTable->hasIndex('trunkline_points_ngdu_id_foreign')) {
                $table->dropIndex('trunkline_points_ngdu_id_foreign');
                $table->dropForeign('trunkline_points_ngdu_id_foreign');
            }

            if ($doctrineTable->hasIndex('trunkline_points_gu_id_foreign')) {
                $table->dropIndex('trunkline_points_gu_id_foreign');
                $table->dropForeign('trunkline_points_gu_id_foreign');
            }

            if ($doctrineTable->hasIndex('trunkline_points_map_pipe_id_foreign')) {
                $table->dropIndex('trunkline_points_map_pipe_id_foreign');
                $table->dropForeign('trunkline_points_map_pipe_id_foreign');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

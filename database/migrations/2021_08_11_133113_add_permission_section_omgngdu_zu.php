<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionSectionOmgngduZu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permission_sections')->insert(
            [
                'code' => 'omgngdu_zu',
                'title_trans' => 'monitoring.omgngdu_zu.menu',
                'module' => 'monitoring'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permission_sections')
            ->where('code', 'omgngdu_zu')
            ->where('module','monitoring')
            ->delete();
    }
}

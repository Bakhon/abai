<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionSectionEquipmentGu extends Migration
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
                'code' => 'agzu',
                'title_trans' => 'monitoring.agzu.title',
                'module' => 'monitoring'
            ]
        );
        DB::table('permission_sections')->insert(
            [
                'code' => 'buffer-tank',
                'title_trans' => 'monitoring.buffer_tank.title',
                'module' => 'monitoring'
            ]
        );
        DB::table('permission_sections')->insert(
            [
                'code' => 'metering-units',
                'title_trans' => 'monitoring.metering_units.title',
                'module' => 'monitoring'
            ]
        );
        DB::table('permission_sections')->insert(
            [
                'code' => 'ovens',
                'title_trans' => 'monitoring.ovens.title',
                'module' => 'monitoring'
            ]
        );
        DB::table('permission_sections')->insert(
            [
                'code' => 'pumps',
                'title_trans' => 'monitoring.pumps.title',
                'module' => 'monitoring'
            ]
        );
        DB::table('permission_sections')->insert(
            [
                'code' => 'sib',
                'title_trans' => 'monitoring.sib.title',
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
            ->where('code', 'agzu')
            ->where('module','monitoring')
            ->delete();

        DB::table('permission_sections')
            ->where('code', 'buffer-tank')
            ->where('module','monitoring')
            ->delete();

        DB::table('permission_sections')
            ->where('code', 'metering-units')
            ->where('module','monitoring')
            ->delete();

        DB::table('permission_sections')
            ->where('code', 'ovens')
            ->where('module','monitoring')
            ->delete();

        DB::table('permission_sections')
            ->where('code', 'pumps')
            ->where('module','monitoring')
            ->delete();

        DB::table('permission_sections')
            ->where('code', 'sib')
            ->where('module','monitoring')
            ->delete();
    

    }
}

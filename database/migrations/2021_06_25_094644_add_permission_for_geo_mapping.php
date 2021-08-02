<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionForGeoMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata list geo_mapping',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata create geo_mapping',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata read geo_mapping',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata update geo_mapping',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata delete geo_mapping',
                'guard_name' => 'web'
            ]
        );

        if (DB::table('role_has_permissions')->where('role_id', 1)->count() > 0) {
            foreach ($ids as $id) {

                DB::table('role_has_permissions')->insert(
                    [
                        'permission_id' => $id,
                        'role_id' => 1
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $peermissionIds = DB::table('permissions')->where('name', 'like', '%geo_mapping%')->pluck('id')->toArray();
        DB::table('permissions')->whereIn('id', $peermissionIds)->delete();
    }
}
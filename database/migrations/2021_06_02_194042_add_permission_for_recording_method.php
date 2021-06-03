<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionForRecordingMethod extends Migration
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
                'name' => 'bigdata list recording_method',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata create recording_method',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata read recording_method',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata update recording_method',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'bigdata delete recording_method',
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
        $peermissionIds = DB::table('permissions')->where('name', 'like', '%recording_method%')->pluck('id')->toArray();
        DB::table('permissions')->whereIn('id', $peermissionIds)->delete();
    }
}

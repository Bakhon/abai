<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionsForPipeTypes extends Migration
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
                'name' => 'monitoring list pipe_types',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring create pipe_types',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring read pipe_types',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring update pipe_types',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring delete pipe_types',
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
        $peermissionIds = DB::table('permissions')->where('name', 'like', '%pipe_types%')->pluck('id')->toArray();
        DB::table('permissions')->whereIn('id', $peermissionIds)->delete();
    }
}

<?php

use Illuminate\Database\Migrations\Migration;

class AddPermissionsForPumps extends Migration
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
                'name' => 'monitoring list pumps',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring create pumps',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring read pumps',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring update pumps',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring delete pumps',
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
        $peermissionIds = DB::table('permissions')->where('name', 'like', '%pumps%')->pluck('id')->toArray();
        DB::table('permissions')->whereIn('id', $peermissionIds)->delete();
    }
}

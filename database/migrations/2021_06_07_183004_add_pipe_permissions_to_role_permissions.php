<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class AddPipePermissionsToRolePermissions extends Migration
{
    protected $permissions = [
        'monitoring create gu',
        'monitoring update gu',
        'monitoring delete gu',
        'monitoring create zu',
        'monitoring update zu',
        'monitoring delete zu',
        'monitoring create well',
        'monitoring update well',
        'monitoring delete well',
        'monitoring create pipe',
        'monitoring update pipe',
        'monitoring delete pipe'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            $ids[] = DB::table('permissions')->insertGetId(
                [
                    'name' => $permission,
                    'guard_name' => 'web'
                ]
            );
        }

        foreach ($ids as $id) {

            DB::table('role_has_permissions')->insert(
                [
                    'permission_id' => $id,
                    'role_id' => 1
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissionIds = Permission::whereIn('name', $this->permissions)->pluck('id');
        DB::table('role_has_permissions')
            ->whereIn('permission_id', $permissionIds)
            ->delete();

        Permission::whereIn('name', $this->permissions)->delete();
    }
}

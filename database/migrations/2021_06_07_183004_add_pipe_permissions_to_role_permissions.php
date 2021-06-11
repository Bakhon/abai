<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $permissionIds = Permission::whereIn('name', $this->permissions)->pluck('id');
        $role = Role::where('guard_name', 'map-admin')->first();

        DB::table('role_has_permissions')
            ->whereIn('permission_id', $permissionIds)
            ->delete();

        foreach ($permissionIds as $permissionId) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permissionId,
                'role_id' => $role->id
            ]);
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
    }
}

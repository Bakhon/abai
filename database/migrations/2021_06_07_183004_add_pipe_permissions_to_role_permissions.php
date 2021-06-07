<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPipePermissionsToRolePermissions extends Migration
{
    protected $permissions = [
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
        $permissions = Permission::whereIn('name', $this->permissions)->get();
        $role = Role::where('guard_name', 'map-admin')->first();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permission->id,
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
        $role = Role::where('guard_name', 'map-admin')->first();
        DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
    }
}

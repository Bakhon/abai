<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddRoleMapEditor extends Migration
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
        $role = Role::firstOrCreate([
            'name' => 'Администратор Техкарты',
            'guard_name' => 'map-admin'
        ]);

        Permission::whereIn('name', $this->permissions)->update(['guard_name' => 'map-admin']);
        $permissions = Permission::whereIn('name', $this->permissions)->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->where('permission_id', $permission->id)->update(
                [
                    'role_id' => $role->id
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
        Permission::whereIn('name', $this->permissions)->update(['guard_name' => 'web']);
        Role::where('guard_name','map-admin')->delete();

        $permissions = Permission::whereIn('name', $this->permissions)->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->where('permission_id', $permission->id)->update(
                [
                    'role_id' => 1
                ]
            );
        }
    }
}

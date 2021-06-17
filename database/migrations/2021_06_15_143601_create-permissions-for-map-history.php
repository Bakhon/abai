<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class CreatePermissionsForMapHistory extends Migration
{
    protected $permissions = [
        'monitoring list map-history',
        'monitoring view map-history',
        'monitoring update map-history'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            $permissionsIds[] = DB::table('permissions')->insertGetId(
                [
                    'name' => $permission,
                    'guard_name' => 'map-admin'
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
        DB::table('role_has_permissions')->whereIn('permission_id', $permissionIds)->delete();
        DB::table('permissions')->whereIn('id', $permissionIds)->delete();
    }
}

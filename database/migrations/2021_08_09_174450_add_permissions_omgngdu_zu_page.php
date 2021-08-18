<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class AddPermissionsOmgngduZuPage extends Migration
{
    protected $permissions = [
        'monitoring create omgngdu_zu',
        'monitoring update omgngdu_zu',
        'monitoring delete omgngdu_zu',
        'monitoring list omgngdu_zu',
        'monitoring view omgngdu_zu',
        'monitoring read omgngdu_zu',
        'monitoring export omgngdu_zu',
        'monitoring view history omgngdu_zu',
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

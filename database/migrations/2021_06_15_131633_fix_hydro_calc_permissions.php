<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FixHydroCalcPermissions extends Migration
{

    protected $permissions = [
        'monitoring list hydro_calculation',
        'monitoring export hydro_calculation',
        'monitoring read hydro_calculation',
        'monitoring list reverse_calculation',
        'monitoring read reverse_calculation'
    ];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissionIds = Permission::whereIn('name', $this->permissions)->pluck('id');
        $role = Role::where('name', 'Администратор модуля Мониторинг')->first();

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
        //
    }
}

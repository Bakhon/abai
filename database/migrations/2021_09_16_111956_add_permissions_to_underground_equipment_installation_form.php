<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToUndergroundEquipmentInstallationForm extends Migration
{
    protected $permissions;
    protected $permissionSection;

    public function __construct()
    {
        $this->permissions = json_decode(
            '[{"name":"bigdata list underground_equipment_installation","guard_name":"web"},{"name":"bigdata create underground_equipment_installation","guard_name":"web"},{"name":"bigdata update underground_equipment_installation","guard_name":"web"},{"name":"bigdata view history underground_equipment_installation","guard_name":"web"},{"name":"bigdata delete underground_equipment_installation","guard_name":"web"}]',
            1
        );
        $this->permissionSection = json_decode(
            '{"code":"underground_equipment_installation","title_trans":"bd.forms.underground_equipment_installation.title","module":"bigdata"}',
            1
        );
    }

    public function up()
    {
        foreach ($this->permissions as $permission) {
            $row = DB::table('permissions')
                ->where('name', $permission['name'])
                ->where('guard_name', $permission['guard_name'])
                ->first();

            if (!empty($row)) {
                continue;
            }

            DB::table('permissions')->insert($permission);
        }

        DB::table('permission_sections')->insert($this->permissionSection);
    }

    public function down()
    {
        foreach ($this->permissions as $permission) {
            DB::table('permissions')
                ->where('name', $permission['name'])
                ->where('guard_name', $permission['guard_name'])
                ->delete();

            DB::table('permission_sections')
                ->where('code', $this->permissionSection['code'])
                ->delete();
        }
    }
}

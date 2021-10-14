<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToMeasCurrentGdisForm extends Migration
{
    protected $permissions;
    protected $permissionSection;

    public function __construct()
    {
        $this->permissions = json_decode('[{"name":"bigdata list meas_current_gdis","guard_name":"web"},{"name":"bigdata create meas_current_gdis","guard_name":"web"},{"name":"bigdata update meas_current_gdis","guard_name":"web"},{"name":"bigdata view history meas_current_gdis","guard_name":"web"},{"name":"bigdata delete meas_current_gdis","guard_name":"web"}]', 1);
        $this->permissionSection = json_decode('{"code":"meas_current_gdis","title_trans":"bd.forms.meas_current_gdis.title","module":"bigdata"}', 1);
    }

    public function up()
    {
        foreach ($this->permissions as $permission) {
            $row = DB::table('permissions')
                ->where('name', $permission['name'])
                ->where('guard_name', $permission['guard_name'])
                ->first();

            if(!empty($row)) continue;

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
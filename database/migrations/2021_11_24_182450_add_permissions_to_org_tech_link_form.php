<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToOrgTechLinkForm extends Migration
{
    protected $permissions;
    protected $permissionSection;

    public function __construct()
    {
        $this->permissions = json_decode('[{"name":"bigdata list org_tech_link","guard_name":"web"},{"name":"bigdata create org_tech_link","guard_name":"web"},{"name":"bigdata update org_tech_link","guard_name":"web"},{"name":"bigdata view history org_tech_link","guard_name":"web"},{"name":"bigdata delete org_tech_link","guard_name":"web"}]', 1);
        $this->permissionSection = json_decode('{"code":"org_tech_link","title_trans":"bd.forms.org_tech_link.title","module":"bigdata"}', 1);
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

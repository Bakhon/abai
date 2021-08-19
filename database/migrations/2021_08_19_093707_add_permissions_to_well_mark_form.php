<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToWellMarkForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bigdata list well_mark","guard_name":"web"},{"name":"bigdata create well_mark","guard_name":"web"},{"name":"bigdata update well_mark","guard_name":"web"},{"name":"bigdata view history well_mark","guard_name":"web"},{"name":"bigdata delete well_mark","guard_name":"web"}]', 1);

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode('{"code":"well_mark","title_trans":"bd.forms.well_mark.title","module":"bigdata"}', 1);
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

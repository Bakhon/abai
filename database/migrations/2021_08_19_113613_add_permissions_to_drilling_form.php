<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToDrillingForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bigdata list drilling","guard_name":"web"},{"name":"bigdata create drilling","guard_name":"web"},{"name":"bigdata update drilling","guard_name":"web"},{"name":"bigdata view history drilling","guard_name":"web"},{"name":"bigdata delete drilling","guard_name":"web"}]', 1);

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode('{"code":"drilling","title_trans":"bd.forms.drilling.title","module":"bigdata"}', 1);
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

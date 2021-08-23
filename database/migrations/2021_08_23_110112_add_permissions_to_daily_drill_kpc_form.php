<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToDailyDrillKpcForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bigdata list daily_drill_kpc","guard_name":"web"},{"name":"bigdata create daily_drill_kpc","guard_name":"web"},{"name":"bigdata update daily_drill_kpc","guard_name":"web"},{"name":"bigdata view history daily_drill_kpc","guard_name":"web"},{"name":"bigdata delete daily_drill_kpc","guard_name":"web"}]', 1);

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode('{"code":"daily_drill_kpc","title_trans":"bd.forms.daily_drill_kpc.title","module":"bigdata"}', 1);
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

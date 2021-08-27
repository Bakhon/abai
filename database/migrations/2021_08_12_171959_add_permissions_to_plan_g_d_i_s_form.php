<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToPlanGDISForm extends Migration
{
    public function up()
    {
        $permissions = json_decode(
            '[{"name":"bigdata list plan_g_d_i_s","guard_name":"web"},{"name":"bigdata create plan_g_d_i_s","guard_name":"web"},{"name":"bigdata update plan_g_d_i_s","guard_name":"web"},{"name":"bigdata view history plan_g_d_i_s","guard_name":"web"},{"name":"bigdata delete plan_g_d_i_s","guard_name":"web"}]',
            1
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode(
            '{"code":"plan_g_d_i_s","title_trans":"bd.forms.plan_g_d_i_s.title","module":"bigdata"}',
            1
        );
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToCurrentGDISForm extends Migration
{
    public function up()
    {
        $permissions = json_decode(
            '[{"name":"bigdata list current_g_d_i_s","guard_name":"web"},{"name":"bigdata create current_g_d_i_s","guard_name":"web"},{"name":"bigdata update current_g_d_i_s","guard_name":"web"},{"name":"bigdata view history current_g_d_i_s","guard_name":"web"},{"name":"bigdata delete current_g_d_i_s","guard_name":"web"}]',
            1
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode(
            '{"code":"current_g_d_i_s","title_trans":"bd.forms.current_g_d_i_s.title","module":"bigdata"}',
            1
        );
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

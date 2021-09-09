<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToZuGzuProductionForm extends Migration
{
    public function up()
    {
        $permissions = json_decode(
            '[{"name":"bigdata list zu_gzu_production","guard_name":"web"},{"name":"bigdata create zu_gzu_production","guard_name":"web"},{"name":"bigdata update zu_gzu_production","guard_name":"web"},{"name":"bigdata view history zu_gzu_production","guard_name":"web"},{"name":"bigdata delete zu_gzu_production","guard_name":"web"}]',
            1
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode(
            '{"code":"zu_gzu_production","title_trans":"bd.forms.zu_gzu_production.title","module":"bigdata"}',
            1
        );
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

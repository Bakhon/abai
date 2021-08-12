<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToWellTreatForm extends Migration
{
    public function up()
    {
        $permissions = json_decode(
            '[{"name":"bigdata list well_treat","guard_name":"web"},{"name":"bigdata create well_treat","guard_name":"web"},{"name":"bigdata update well_treat","guard_name":"web"},{"name":"bigdata view history well_treat","guard_name":"web"},{"name":"bigdata delete well_treat","guard_name":"web"}]',
            1
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode(
            '{"code":"well_treat","title_trans":"bd.forms.well_treat.title","module":"bigdata"}',
            1
        );
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToMeasLabResearchForm extends Migration
{
    public function up()
    {
        $permissions = json_decode(
            '[{"name":"bigdata list meas_lab_research","guard_name":"web"},{"name":"bigdata create meas_lab_research","guard_name":"web"},{"name":"bigdata update meas_lab_research","guard_name":"web"},{"name":"bigdata view history meas_lab_research","guard_name":"web"},{"name":"bigdata delete meas_lab_research","guard_name":"web"}]',
            1
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode(
            '{"code":"meas_lab_research","title_trans":"bd.forms.meas_lab_research.title","module":"bigdata"}',
            1
        );
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

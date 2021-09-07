<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToTechWaterWellForm extends Migration
{
    public function up()
    {
        $permissions = json_decode(
            '[{"name":"bigdata list tech_water_well","guard_name":"web"},{"name":"bigdata create tech_water_well","guard_name":"web"},{"name":"bigdata update tech_water_well","guard_name":"web"},{"name":"bigdata view history tech_water_well","guard_name":"web"},{"name":"bigdata delete tech_water_well","guard_name":"web"}]',
            1
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode(
            '{"code":"tech_water_well","title_trans":"bd.forms.tech_water_well.title","module":"bigdata"}',
            1
        );
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

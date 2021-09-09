<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToResearchLabResearchForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bigdata list research_lab_research","guard_name":"web"},{"name":"bigdata create research_lab_research","guard_name":"web"},{"name":"bigdata update research_lab_research","guard_name":"web"},{"name":"bigdata view history research_lab_research","guard_name":"web"},{"name":"bigdata delete research_lab_research","guard_name":"web"}]', 1);

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode('{"code":"research_lab_research","title_trans":"bd.forms.research_lab_research.title","module":"bigdata"}', 1);
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

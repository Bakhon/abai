<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToDailyReportsPrsForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bigdata list daily_reports_prs","guard_name":"web"},{"name":"bigdata create daily_reports_prs","guard_name":"web"},{"name":"bigdata update daily_reports_prs","guard_name":"web"},{"name":"bigdata view history daily_reports_prs","guard_name":"web"},{"name":"bigdata delete daily_reports_prs","guard_name":"web"}]', 1);

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        $permissionSection = json_decode('{"code":"daily_reports_prs","title_trans":"bd.forms.daily_reports_prs.title","module":"bigdata"}', 1);
        DB::table('permission_sections')->insert($permissionSection);
    }

    public function down()
    {
    }
}

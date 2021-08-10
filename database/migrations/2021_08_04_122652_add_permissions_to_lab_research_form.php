<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToLabResearchForm extends Migration
{
    public function up()
    {
        $permissions = json_decode(
            '[{"name":"bigdata list lab_research","guard_name":"web"},{"name":"bigdata create lab_research","guard_name":"web"},{"name":"bigdata update lab_research","guard_name":"web"},{"name":"bigdata view history lab_research","guard_name":"web"},{"name":"bigdata delete lab_research","guard_name":"web"}]',
            1
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        DB::table('permission_sections')->insert(
            [
                'code' => 'lab_research',
                'title' => 'bd.forms.lab_research.title',
                'module' => 'bigdata'
            ]
        );
    }

    public function down()
    {
    }
}

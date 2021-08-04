<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToGdisForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bd forms gdis list","guard_name":"web"},{"name":"bd forms gdis create","guard_name":"web"},{"name":"bd forms gdis edit","guard_name":"web"},{"name":"bd forms gdis history","guard_name":"web"},{"name":"bd forms gdis delete","guard_name":"web"}]', 1);

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
    }

    public function down()
    {
    }
}

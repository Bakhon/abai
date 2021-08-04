<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToGdisForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bigdata gdis list","guard_name":"web"},{"name":"bigdata gdis create","guard_name":"web"},{"name":"bigdata gdis edit","guard_name":"web"},{"name":"bigdata gdis history","guard_name":"web"},{"name":"bigdata gdis delete","guard_name":"web"}]', 1);

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
    }

    public function down()
    {
    }
}

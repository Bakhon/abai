<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToWellDocumentForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bd forms well_document list","guard_name":"web"},{"name":"bd forms well_document create","guard_name":"web"},{"name":"bd forms well_document edit","guard_name":"web"},{"name":"bd forms well_document history","guard_name":"web"},{"name":"bd forms well_document delete","guard_name":"web"}]', 1);

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
    }

    public function down()
    {
    }
}

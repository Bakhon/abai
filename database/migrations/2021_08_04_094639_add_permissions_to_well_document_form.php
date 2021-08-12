<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\PermissionSection;

class AddPermissionsToWellDocumentForm extends Migration
{
    public function up()
    {
        $permissions = json_decode('[{"name":"bigdata well_document list","guard_name":"web"},{"name":"bigdata well_document create","guard_name":"web"},{"name":"bigdata well_document edit","guard_name":"web"},{"name":"bigdata well_document history","guard_name":"web"},{"name":"bigdata well_document delete","guard_name":"web"}]', 1);
        PermissionSection::create(
            [
                'code' => 'well_document',
                'title_trans' => 'Документ скважины',
                'module' => 'bigdata'
            ]
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
    }

    public function down()
    {
    }
}

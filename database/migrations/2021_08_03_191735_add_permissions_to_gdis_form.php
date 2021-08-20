<?php

use App\Models\PermissionSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionsToGdisForm extends Migration
{
    public function up()
    {
        $permissions = json_decode(
            '[{"name":"bigdata list gdis","guard_name":"web"},{"name":"bigdata create gdis","guard_name":"web"},{"name":"bigdata update gdis","guard_name":"web"},{"name":"bigdata view history gdis","guard_name":"web"},{"name":"bigdata delete gdis","guard_name":"web"}]',
            1
        );
        PermissionSection::create(
            [
                'code' => 'gdis',
                'title_trans' => 'Сложные ГДИС',
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

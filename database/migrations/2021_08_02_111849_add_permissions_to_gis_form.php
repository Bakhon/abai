<?php

use App\Models\PermissionSection;
use Illuminate\Database\Migrations\Migration;

class AddPermissionsToGisForm extends Migration
{
    public function up()
    {
        $actions = [
            'list',
            'create',
            'update',
            'view history',
            'delete',
        ];

        PermissionSection::create(
            [
                'code' => 'gis_type',
                'title_trans' => 'ГИС',
                'module' => 'bigdata'
            ]
        );

        foreach ($actions as $action) {
            $permissions[] = 'bigdata ' . $action . ' gis_type';
        }

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert(
                [
                    'name' => $permission,
                    'guard_name' => 'web'
                ]
            );
        }
    }

    public function down()
    {
    }
}

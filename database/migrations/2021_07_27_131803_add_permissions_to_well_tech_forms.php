<?php

use Illuminate\Database\Migrations\Migration;

class AddPermissionsToWellTechForms extends Migration
{
    public function up()
    {
        $actions = [
            'list',
            'create',
            'edit',
            'history',
            'delete',
        ];

        $forms = [
            'well_tech_disconnect',
            'well_tech_change_disconnect',
            'well_tech_cancel_disconnect'
        ];
        $permissions = [];

        foreach ($forms as $form) {
            foreach ($actions as $action) {
                $permissions[] = 'bd forms ' . $form . ' ' . $action;
            }
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
}
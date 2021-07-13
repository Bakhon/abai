<?php

use Illuminate\Database\Migrations\Migration;

class AddPermissionsToBdForms extends Migration
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

        $forms = json_decode(File::get(resource_path('js/json/bd/forms.json')));
        $permissions = [];

        foreach ($forms as $form) {
            foreach ($actions as $action) {
                $permissions[] = 'bd forms ' . $form->code . ' ' . $action;
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

    public function down()
    {
    }
}

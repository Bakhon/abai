<?php

use App\Models\PermissionSection;
use Illuminate\Database\Migrations\Migration;

class NewPermissionsToBdForms extends Migration
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

        $forms = json_decode(File::get(resource_path('js/json/bd/forms.json')));
        $permissions = [];

        foreach ($forms as $form) {
            PermissionSection::create(
                [
                    'code' => $form->code,
                    'title_trans' => 'bd.forms.' . $form->code . '.title',
                    'module' => 'bigdata'
                ]
            );

            foreach ($actions as $action) {
                $permissions[] = 'bigdata ' . $action . ' ' . $form->code;
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

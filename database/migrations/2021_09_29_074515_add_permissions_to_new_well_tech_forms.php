<?php

use Illuminate\Database\Migrations\Migration;

class AddPermissionsToNewWellTechForms extends Migration
{
    protected $permissions;
    protected $permissionSections;

    public function __construct()
    {
        $actions = [
            'list',
            'create',
            'edit',
            'history',
            'delete',
        ];

        $forms = [
            'well_tech_connect',
            'well_tech_change_tap',
            'well_tech_change_tech',
            'cancel_connection'
        ];
        $this->permissions = [];

        foreach ($forms as $form) {
            foreach ($actions as $action) {
                $this->permissions[] = 'bd forms ' . $form . ' ' . $action;
            }
        }

        $this->permissionSections = [
            [
                'code' => 'well_tech_connect',
                'title_trans' => 'bd.forms.well_tech_connect.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'well_tech_change_tap',
                'title_trans' => 'bd.forms.well_tech_change_tap.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'well_tech_change_tech',
                'title_trans' => 'bd.forms.well_tech_change_tech.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'cancel_connection',
                'title_trans' => 'bd.forms.cancel_connection.title',
                'module' => 'bigdata'
            ],
        ];
    }

    public function up()
    {
        foreach ($this->permissions as $permission) {
            $row = DB::table('permissions')
                ->where('name', $permission)
                ->where('guard_name', 'web')
                ->first();

            if (!empty($row)) {
                continue;
            }

            DB::table('permissions')->insert([
                                                 'name' => $permission,
                                                 'guard_name' => 'web'
                                             ]);
        }


        foreach ($this->permissionSections as $section) {
            DB::table('permission_sections')->insert($section);
        }
    }


    public function down()
    {
        foreach ($this->permissions as $permission) {
            DB::table('permissions')
                ->where('name', $permission)
                ->where('guard_name', 'web')
                ->delete();
        }

        foreach ($this->permissionSections as $section) {
            DB::table('permission_sections')
                ->where('code', $section['code'])
                ->delete();
        }
    }
}
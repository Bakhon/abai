<?php

use App\Models\PermissionSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermitionToWellsSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $actions = [
            'list',
        ];

        $forms = json_decode(File::get(resource_path('js/json/bd/forms.json')));
        $permissions = [];

        foreach ($forms as $form) {
            if (in_array($form->code, [
                'production_wells_schedule',
                'injection_wells_schedule',
                'distribution_substation',
                'joint_wells'
            ])) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wells_schedule', function (Blueprint $table) {
            //
        });
    }
}

<?php

use App\Models\PermissionSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class AddPermissionsForMapConstructor extends Migration
{
    public $permissions = [
        'mapConstructor view main',
        'mapConstructor list main',
        'mapConstructor create main',
        'mapConstructor read main',
        'mapConstructor update main',
        'mapConstructor delete main',
        'mapConstructor export main'
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'web'
                ]
            );
        }

        PermissionSection::firstOrCreate(
            [
                'code' => 'mapConstructor',
                'title_trans' => 'map_constructor.map_constructor',
                'module' => 'mapConstructor'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

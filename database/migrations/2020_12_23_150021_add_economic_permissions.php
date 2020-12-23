<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEconomicPermissions extends Migration
{
    public function up()
    {
        $permissions = [
            'economic view main',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(
                [
                    'name' => $permission,
                    'guard' => 'web'
                ]
            );
        }
    }

    public function down()
    {
    }
}

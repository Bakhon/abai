<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionToReportToMonitoring extends Migration
{
    public function up()
    {
            $permissions = [
                'monitoring make report',
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

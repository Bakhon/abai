<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPermissionsToPipesCruds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'monitoring list gu',
            'monitoring create gu',
            'monitoring read gu',
            'monitoring update gu',
            'monitoring delete gu',
            'monitoring export gu',
            'monitoring view history gu',
            'monitoring list zu',
            'monitoring create zu',
            'monitoring read zu',
            'monitoring update zu',
            'monitoring delete zu',
            'monitoring export zu',
            'monitoring view history zu',
            'monitoring list well',
            'monitoring create well',
            'monitoring read well',
            'monitoring update well',
            'monitoring delete well',
            'monitoring export well',
            'monitoring view history well',
            'monitoring list pipe',
            'monitoring create pipe',
            'monitoring read pipe',
            'monitoring update pipe',
            'monitoring delete pipe',
            'monitoring export pipe',
            'monitoring view history pipe',
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

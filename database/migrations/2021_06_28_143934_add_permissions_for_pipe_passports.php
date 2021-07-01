<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionsForPipePassports extends Migration
{
    private $permissions = [
        'monitoring list pipe-passport',
        'monitoring create pipe-passport',
        'monitoring read pipe-passport',
        'monitoring update pipe-passport',
        'monitoring delete pipe-passport',
        'monitoring view history pipe-passport'
    ];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            $ids[] = DB::table('permissions')->insertGetId(
                [
                    'name' => $permission,
                    'guard_name' => 'web'
                ]
            );
        }

        foreach ($ids as $id) {

            DB::table('role_has_permissions')->insert(
                [
                    'permission_id' => $id,
                    'role_id' => 1
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
        $peermissionIds = DB::table('permissions')->where('name', 'like', '%pipe-passport%')->pluck('id')->toArray();
        DB::table('permissions')->whereIn('id', $peermissionIds)->delete();
    }
}

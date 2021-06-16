<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RenameGuardNameToWeb extends Migration
{
    protected $permissions = [
        'monitoring list map-history',
        'monitoring view map-history',
        'monitoring update map-history',
        'monitoring create gu',
        'monitoring update gu',
        'monitoring delete gu',
        'monitoring create zu',
        'monitoring update zu',
        'monitoring delete zu',
        'monitoring create well',
        'monitoring update well',
        'monitoring delete well',
        'monitoring create pipe',
        'monitoring update pipe',
        'monitoring delete pipe'

    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::where('guard_name', 'map-admin')->update(['guard_name' => 'web']);
        Role::where('guard_name', 'map-admin')->update(['guard_name' => 'web']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::whereIn('name', $this->permissions)->update(['guard_name' => 'map-admin']);
        Role::where('name', 'Администратор Техкарты')->update(['guard_name' => 'map-admin']);
    }
}

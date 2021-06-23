<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;

class PodborGNOPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = "podborGno view main";
        $permission->save();
    }
}

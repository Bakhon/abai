<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;

class TrEditPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = "tr edit";
        $permission->save();
    }
}

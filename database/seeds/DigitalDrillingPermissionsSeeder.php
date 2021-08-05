<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;

class DigitalDrillingPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = "digitalDrilling view main";
        $permission->save();
    }
}

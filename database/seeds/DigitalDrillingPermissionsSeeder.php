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
        Permission::updateOrCreate(
            ['name' => 'digitalDrilling view main'],
            ['guard_name' => 'web']
        );

        Permission::updateOrCreate(
            ['name' => 'digitalDrilling view catalog'],
            ['guard_name' => 'web']
        );
    }
}

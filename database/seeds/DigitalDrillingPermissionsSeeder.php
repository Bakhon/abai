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
        \Spatie\Permission\Models\Permission::create(
            [
                'name' => 'digitalDrilling view main',
                'guard_name' => 'web'
            ]
        );

        \Spatie\Permission\Models\Permission::create(
            [
                'name' => 'digitalDrilling view catalog',
                'guard_name' => 'web'
            ]
        );
    }
}

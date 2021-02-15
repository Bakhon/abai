<?php

use Illuminate\Database\Seeder;

class PodborGTMPermissionsSeeder extends Seeder
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
                'name' => 'podborGtm view main',
      //          'guard' => 'web'
            ]
        );
    }
}

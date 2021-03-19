<?php

use Illuminate\Database\Seeder;

class PodborGNOPermissionsSeeder extends Seeder
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
                'name' => 'podborGno view main',
      //          'guard' => 'web'
            ]
        );
    }
}

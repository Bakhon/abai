<?php

use Illuminate\Database\Seeder;

class VisCenterPermissionsSeeder extends Seeder
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
                'name' => 'visualcenter view main',
               // 'guard_name' => 'web'
            ]
        );
    }
}

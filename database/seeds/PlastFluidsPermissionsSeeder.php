<?php

use Illuminate\Database\Seeder;

class PlastFluidsPermissionsSeeder extends Seeder
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
                'name' => 'plastFluids view main',
                'guard_name' => 'web'
            ]
        );
    }
}

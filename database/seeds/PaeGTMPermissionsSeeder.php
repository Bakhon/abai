<?php

use Illuminate\Database\Seeder;

class PaeGTMPermissionsSeeder extends Seeder
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
                'name' => 'paegtm view main',
      //          'guard' => 'web'
            ]
        );
    }
}

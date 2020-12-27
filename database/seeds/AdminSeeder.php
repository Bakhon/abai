<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::create(
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('nK3G8uQ')
            ]
        );
    }
}

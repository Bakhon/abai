<?php

use Illuminate\Database\Seeder;

class ThionicBacteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Refs\ThionicBacteria::create([
            'name' => '<10'
        ]);

        \App\Models\Refs\ThionicBacteria::create([
            'name' => '10'
        ]);

        \App\Models\Refs\ThionicBacteria::create([
            'name' => '10^2'
        ]);

        \App\Models\Refs\ThionicBacteria::create([
            'name' => '10^3'
        ]);

        \App\Models\Refs\ThionicBacteria::create([
            'name' => '10^4'
        ]);

        \App\Models\Refs\ThionicBacteria::create([
            'name' => '10^5'
        ]);

        \App\Models\Refs\ThionicBacteria::create([
            'name' => '10^6'
        ]);

        \App\Models\Refs\ThionicBacteria::create([
            'name' => '10^7'
        ]);
    }
}

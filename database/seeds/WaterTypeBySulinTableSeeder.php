<?php

use Illuminate\Database\Seeder;

class WaterTypeBySulinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Refs\WaterTypeBySulin::create([
            'name' => 'Cl-Ca'
        ]);

        \App\Models\Refs\WaterTypeBySulin::create([
            'name' => 'Cl-Mg'
        ]);

        \App\Models\Refs\WaterTypeBySulin::create([
            'name' => 'SO4-Na'
        ]);

        \App\Models\Refs\WaterTypeBySulin::create([
            'name' => 'HCO₃-Na'
        ]);
    }
}

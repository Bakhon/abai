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
        App\Models\WaterTypeBySulin::create([
            'name' => 'Cl-Ca'
        ]);

        App\Models\WaterTypeBySulin::create([
            'name' => 'Cl-Mg'
        ]);

        App\Models\WaterTypeBySulin::create([
            'name' => 'SO4-Na'
        ]);

        App\Models\WaterTypeBySulin::create([
            'name' => 'HCO₃-Na'
        ]);
    }
}

<?php

use App\Imports\WaterMeasurementsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class WaterMeasurementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new WaterMeasurementsImport, public_path('water.xlsx'));
    }
}

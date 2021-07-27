<?php

use App\Imports\MeteringUnitsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MeteringUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new MeteringUnitsImport, public_path('imports/meteringunits.xlsx'));
    }
}

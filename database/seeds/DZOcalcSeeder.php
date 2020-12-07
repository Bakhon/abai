<?php

use App\Imports\DZOcalcImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DZOcalcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new DZOcalcImport, public_path('Calc_dzo.xlsx'));
    }
}

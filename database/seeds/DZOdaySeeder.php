<?php

use App\Imports\DZOdayImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DZOdaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new DZOdayImport, public_path('Total_dzo.xlsx'));
    }
}

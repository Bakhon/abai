<?php

use App\Imports\WellsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class WellTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new WellsImport, public_path('well.xlsx'));
    }
}

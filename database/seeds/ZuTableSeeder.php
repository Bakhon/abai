<?php

use App\Imports\ZusImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ZuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new ZusImport, public_path('zu.xlsx'));
    }
}

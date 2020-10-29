<?php

use App\Imports\GusImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class GuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new GusImport, public_path('gu.xlsx'));
    }
}

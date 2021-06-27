<?php

use App\Imports\SibImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SibTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SibImport, public_path('sib.xlsx'));
    }
}

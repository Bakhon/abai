<?php

use App\Imports\OvensImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class OvensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new OvensImport, public_path('ovens.xlsx'));
    }
}

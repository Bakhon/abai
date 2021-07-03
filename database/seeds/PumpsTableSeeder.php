<?php

use App\Imports\PumpsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class PumpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new PumpsImport, public_path('imports/pumps.xlsx'));
    }
}

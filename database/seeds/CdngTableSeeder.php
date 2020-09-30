<?php

use App\Imports\CdngsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CdngTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new CdngsImport, public_path('cdng.xlsx'));
    }
}

<?php

use App\Imports\ZuCleaningsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;


class ZuCleaningsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new ZuCleaningsImport, public_path('imports/zu_cleanings.xlsx'));
    }
}

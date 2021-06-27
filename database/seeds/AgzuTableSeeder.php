<?php

use App\Imports\AgzuImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;


class AgzuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new AgzuImport, public_path('agzu.xlsx'));
    }
}

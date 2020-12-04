<?php

use App\Imports\DZOyearImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DZOyearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new DZOyearImport, public_path('Total_dzo_year.xlsx'));
    }
}

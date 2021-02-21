<?php

use Illuminate\Database\Seeder;
use App\Imports\EcoRefsCostImport;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new EcoRefsCostImport, public_path('imports/EcoRefsCost_2020.xlsx'));
    }
}

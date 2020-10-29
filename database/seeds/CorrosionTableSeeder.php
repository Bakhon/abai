<?php

use App\Imports\CorrosionImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CorrosionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new CorrosionImport, public_path('corrosion.xlsx'));
    }
}

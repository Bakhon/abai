<?php

use App\Imports\GuKormassImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class KormassGuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new GuKormassImport, public_path('kormass.xlsx'));
    }
}

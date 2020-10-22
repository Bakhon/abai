<?php

use App\Imports\BactericideImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class BactericideTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new BactericideImport, public_path('bactericide.xlsx'));
    }
}

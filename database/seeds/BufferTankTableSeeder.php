<?php

use App\Imports\BufferTankImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class BufferTankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new BufferTankImport, public_path('imports/buffertank.xlsx'));
    }
}

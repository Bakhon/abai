<?php

use App\Imports\OtherObjectsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class OtherObjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new OtherObjectsImport, public_path('otherObjects.xlsx'));
    }
}

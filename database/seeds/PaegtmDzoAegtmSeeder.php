<?php

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PaegtmDzoAegtmImport;

class PaegtmDzoAegtmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new PaegtmDzoAegtmImport(), public_path('imports/paegtm_dzo_aegtm.xlsx'));
    }
}

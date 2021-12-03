<?php

use App\Imports\PaegtmUnsuccessfulGtmFactorsImport;
use Illuminate\Database\Seeder;

class PaegtmUnsuccessfulGtmFactorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new PaegtmUnsuccessfulGtmFactorsImport(), public_path('imports/paegtm_unsuccessful_gtms_factors.xlsx'));
    }
}

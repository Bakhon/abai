<?php

use App\Imports\PaegtmGtmFactorAnalysisImport;
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
        Excel::import(new PaegtmGtmFactorAnalysisImport(), public_path('imports/paegtm_unsuccessful_gtms_factors.xlsx'));
    }
}

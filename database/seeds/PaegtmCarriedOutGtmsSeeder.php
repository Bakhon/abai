<?php

use App\Imports\PaegtmCarriedOutGtmsImport;
use Illuminate\Database\Seeder;

class PaegtmCarriedOutGtmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new PaegtmCarriedOutGtmsImport(), public_path('imports/paegtm_carried_out_gtms.xlsx'));
    }
}

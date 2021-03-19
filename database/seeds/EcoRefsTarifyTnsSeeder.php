<?php

use Illuminate\Database\Seeder;
use App\Imports\EcoRefsTarifyTnsAAImport;
use App\Imports\EcoRefsTarifyTnsKTKImport;
use App\Imports\EcoRefsTarifyTnsSamaraImport;
use App\Imports\EcoRefsTarifyTnsAktauImport;
use App\Imports\EcoRefsTarifyTnsExportOtherImport;
use App\Imports\EcoRefsTarifyTnsAnpzImport;
use App\Imports\EcoRefsTarifyTnsPnhzImport;
use App\Imports\EcoRefsTarifyTnsPkopImport;
use App\Imports\EcoRefsTarifyTnsKbitumImport;
use App\Imports\EcoRefsTarifyTnsLocalOtherImport;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsTarifyTnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new EcoRefsTarifyTnsAAImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsTarifyTnsKTKImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsTarifyTnsSamaraImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsTarifyTnsAktauImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsTarifyTnsExportOtherImport, public_path('imports/EcoRefsCost_2020.xlsx'));

        Excel::import(new EcoRefsTarifyTnsAnpzImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsTarifyTnsPnhzImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsTarifyTnsPkopImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsTarifyTnsKbitumImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsTarifyTnsLocalOtherImport, public_path('imports/EcoRefsCost_2020.xlsx'));
    }
}
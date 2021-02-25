<?php

use Illuminate\Database\Seeder;
use App\Imports\DiscontCoefBarAAImport;
use App\Imports\DiscontCoefBarKTKImport;
use App\Imports\DiscontCoefBarSamaraImport;
use App\Imports\DiscontCoefBarAktauImport;
use App\Imports\DiscontCoefBarExportOtherImport;
use App\Imports\DiscontCoefBarAnpzImport;
use App\Imports\DiscontCoefBarPnhzImport;
use App\Imports\DiscontCoefBarPkopImport;
use App\Imports\DiscontCoefBarKbitumImport;
use App\Imports\DiscontCoefBarLocalOtherImport;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsDiscontCoefBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new DiscontCoefBarAAImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new DiscontCoefBarKTKImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new DiscontCoefBarSamaraImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new DiscontCoefBarAktauImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new DiscontCoefBarExportOtherImport, public_path('imports/EcoRefsCost_2020.xlsx'));

        Excel::import(new DiscontCoefBarAnpzImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new DiscontCoefBarPnhzImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new DiscontCoefBarPkopImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new DiscontCoefBarKbitumImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new DiscontCoefBarLocalOtherImport, public_path('imports/EcoRefsCost_2020.xlsx'));
    }
}
<?php

use Illuminate\Database\Seeder;
use App\Imports\EcoRefsEmpPerAAImport;
use App\Imports\EcoRefsEmpPerKTKImport;
use App\Imports\EcoRefsEmpPerSamaraImport;
use App\Imports\EcoRefsEmpPerAktauImport;
use App\Imports\EcoRefsEmpPerExportOtherImport;
use App\Imports\EcoRefsEmpPerAnpzImport;
use App\Imports\EcoRefsEmpPerPnhzImport;
use App\Imports\EcoRefsEmpPerPkopImport;
use App\Imports\EcoRefsEmpPerKbitumImport;
use App\Imports\EcoRefsEmpPerLocalOtherImport;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsEmpPerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new EcoRefsEmpPerAAImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsEmpPerKTKImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsEmpPerSamaraImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsEmpPerAktauImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsEmpPerExportOtherImport, public_path('imports/EcoRefsCost_2020.xlsx'));

        Excel::import(new EcoRefsEmpPerAnpzImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsEmpPerPnhzImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsEmpPerPkopImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsEmpPerKbitumImport, public_path('imports/EcoRefsCost_2020.xlsx'));
        Excel::import(new EcoRefsEmpPerLocalOtherImport, public_path('imports/EcoRefsCost_2020.xlsx'));
    }
}
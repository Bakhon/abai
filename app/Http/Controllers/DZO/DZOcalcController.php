<?php

namespace App\Http\Controllers\DZO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DZOcalcImport;
use Maatwebsite\Excel\Facades\Excel;

class DZOcalcController extends Controller
{
    public function importExcel()
    {
        Excel::import(new DZOcalcImport, public_path('Calc_dzo.xlsx'));
    }
}

<?php

namespace App\Http\Controllers\VisCenter\ImportForms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DZOyearImport;
use Maatwebsite\Excel\Facades\Excel;

class DZOyearController extends Controller
{
    public function importExcel()
    {
        Excel::import(new DZOyearImport, public_path('Total_dzo_year.xlsx'));
    }
}

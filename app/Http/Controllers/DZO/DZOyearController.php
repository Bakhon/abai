<?php

namespace App\Http\Controllers\DZO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Import\DZOyearImport;
use Maatwebsite\Excel\Facades\Excel;

class DZOyearController extends Controller
{
    public function importExcel()
    {
        Excel::import(new DZOyearImport, public_path('Total_dzo_year.xlsx'));
    }
}

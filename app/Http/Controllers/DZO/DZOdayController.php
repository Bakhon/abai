<?php

namespace App\Http\Controllers\DZO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DZOdayImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DZOday;

class DZOdayController extends Controller
{
    public function importExcel()
    {
        Excel::import(new DZOdayImport, public_path('Total_dzo.xlsx'));
    }
}

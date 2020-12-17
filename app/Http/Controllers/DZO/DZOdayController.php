<?php

namespace App\Http\Controllers\DZO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DZOdayImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DZOday;
use DB;

class DZOdayController extends Controller
{
    public function importExcel(){
        $data = DB::table('d_z_odays')->orderBy('created_at','desc')->paginate(50);
        return view('viscenterDailyDZO.import_hist_excel', compact('data'));
    }
    public function import(Request $request){
        Excel::import(new DZOdayImport, $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
    }
}

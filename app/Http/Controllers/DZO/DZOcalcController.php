<?php

namespace App\Http\Controllers\DZO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DZOcalcImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DZOcalcController extends Controller
{
    public function importExcel(){
        $data = DB::table('d_z_ocalcs')->orderBy('created_at','desc')->paginate(50);
        return view('viscenterDailyDZO.import_econom_excel', compact('data'));
    }
    public function import(Request $request){
        Excel::import(new DZOcalcImport, $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
    }
}

<?php

namespace App\Http\Controllers\VisCenter\ImportForms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Imports\DZOdailyImport;
use Maatwebsite\Excel\Facades\Excel;

class DZOdailyController extends Controller
{
    public function importExcel(){
        $data = DB::table('d_z_odailies')->orderBy('created_at','desc')->paginate(50);
        return view('viscenterDailyDZO.import_excel', compact('data'));
    }

    public function import(Request $request){
        Excel::import(new DZOdailyImport, $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
    }
        
}

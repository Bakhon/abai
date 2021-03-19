<?php

namespace App\Http\Controllers\VisCenter\ImportForms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DZOdayImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\VisCenter\ImportForms\DZOdaily;
use DB;

class DZOdayController extends Controller
{
    public function importExcel(){
        $data = DB::table('d_z_odailies')->orderBy('created_at','desc')->paginate(50);
        return view('viscenterDailyDZO.import_hist_excel', compact('data'));
    }
    public function import(Request $request){
        Excel::import(new DZOdayImport, $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
    }
}

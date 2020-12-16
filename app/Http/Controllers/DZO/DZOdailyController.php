<?php

namespace App\Http\Controllers\DZO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Imports\DZOdayImport;
use Maatwebsite\Excel\Facades\Excel;

class DZOdailyController extends Controller
{
    public function importExcel(){
        $data = DB::table('d_z_odays')->orderBy('created_at','desc')->paginate(50);
        return view('import_excel', compact('data'));
    }
    public function import(Request $request){
        Excel::import(new DZOdayImport, $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
    }
    // public function importExcel(Request $request)
    // {
    //     $path = $request->file('select_file');
    //     Excel::import(new DZOdailyImport, public_path('Лист Microsoft Excel.csv'));
    // }
    // function excel(Request $request){
    //     $path1 = $request->file('select_file');    
    //     // $file = $request->file;
    // Excel::import(new DZOdailyImport, $path1);
    // echo "Inserted successfuly";
    // }

    // function index(){
    //     $data = DB::table('d_z_odailies')->get();
    //     return view('import_excel', compact('data'));
    // }
    // function import(Request $request){
    //     $this->validate($request, [
    //         'select_file' => 'required|mimes:xls,xlsx'
    //     ]);

    //     $path = $request->file('select_file')->getRealPath();

    //     $data = Excel::load($path)->get();

    //     if($data->count() > 0){
    //         foreach($data->toArray() as $key => $value){
    //             foreach($value as $row){
    //                 $insert_data[] = array(
    //                     'a' => $row['a'],
    //                     'b' => $row['b'],
    //                     'c' => $row['c']
    //                 );
    //             }
    //         }
    //         if(!empty($insert_data)){
    //             DB::table('d_z_odailies')->insert($insert_data);
    //         }
    //     }
    //     return back()->with('success', 'Excel data Imported successfully.');
    // }
}

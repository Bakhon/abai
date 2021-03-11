<?php

namespace App\Http\Controllers\EconomyKenzhe;
use App\Imports\RepTtValueImport;
use App\Models\EconomyKenzhe\RepTt;
use App\Models\EconomyKenzhe\SbhCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    public function index()
    {
        $rep_tt = RepTt::where('parent_id', 0)->with('childRepts')->get()->toArray();

        $rep_tt = json_encode($rep_tt);

        return view('economy_kenzhe.reptt')->with(compact('rep_tt'));
    }

    public function companies()
    {
        $rep_tt = SbhCompany::where('parent_id', 0)->with('childRepts')->get()->toArray();
        
        $rep_tt = json_encode($rep_tt); 

        return view('economy_kenzhe.reptt')->with(compact('rep_tt'));
    }

    public function importRepTt(Request $request){
        if($request->isMethod('GET')){
            $data = DB::table('rep_tt')->orderBy('created_at','desc')->paginate(50);
            return view('economy_kenzhe.import_rep', compact('data'));
        }elseif($request->isMethod('POST')){
            Excel::import(new RepTtValueImport(), $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

    public function company($id, $date){
        $date = date('Y-m-d', strtotime('01-'.$date));
        $company = SbhCompany::find($id);
        $stats = $company->statsBydate($date)->get();
        return view('economy_kenzhe.company')->with(compact('company','stats'));
    }

}
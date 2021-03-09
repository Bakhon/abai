<?php

namespace App\Http\Controllers\Economy;
use App\Models\VisCenter\ImportForms\RepTt;
use App\Models\VisCenter\ImportForms\SbhCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Imports\SbhCompanyImport;
use App\Imports\RepTtImport;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    public function index()
    {
        $rep_tt = RepTt::where('parent_id', 0)->with('childRepts')->get()->toArray();

        $rep_tt = json_encode($rep_tt);
        // $rept = RepTt::whereTitle('Доходы, связанные с прекращаемой деятельностью')->first();
        // $rept->parent_id = 18;
        // $rept->save();
        return view('economy.reptt')->with(compact('rep_tt'));
    }

    public function companies()
    {
        $rep_tt = SbhCompany::where('parent_id', 0)->with('childRepts')->get()->toArray();
        
        $rep_tt = json_encode($rep_tt); 

        return view('economy.reptt')->with(compact('rep_tt'));
    }

    public function importSubholdingCompanies(Request $request){
        if($request->isMethod('GET')){
            $data = DB::table('subholding_companies')->orderBy('created_at','desc')->paginate(50);
            return view('economy.import_sbh', compact('data'));
        }elseif($request->isMethod('POST')){
            
            // Excel::import(new SbhCompanyImport, $request->select_file);
            // return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

    public function importRepTt(Request $request){
        if($request->isMethod('GET')){
            $data = DB::table('rep_tt')->orderBy('created_at','desc')->paginate(50);
            return view('economy.import_rep', compact('data'));
        }elseif($request->isMethod('POST')){
            Excel::import(new RepTtImport, $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

}
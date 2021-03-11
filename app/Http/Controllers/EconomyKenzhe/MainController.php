<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Imports\RepTtValueImport;
use App\Models\EconomyKenzhe\RepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;
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
        $companies = SubholdingCompany::where('parent_id', 0)->with('child_companies')->get()->toArray();
        $companies = json_encode($companies);
        return view('economy_kenzhe.reptt')->with(compact('companies'));
    }

    public function importRepTt(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('economy_kenzhe.import_rep');
        } elseif ($request->isMethod('POST')) {
            Excel::import(new RepTtValueImport(), $request->select_file);
            return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

    public function company($id, $date)
    {
        $date = date('Y-m-d', strtotime('01-' . $date));
        $company = SubholdingCompany::find($id);
        $stats = $company->statsByDate($date)->get();
        return view('economy_kenzhe.company')->with(compact('company', 'stats'));
    }

}
<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Imports\HandbookRepTtValueImport;
use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    public function index()
    {
        $handbookItems = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
        $handbookItems = json_encode($handbookItems);
        return view('economy_kenzhe.reptt')->with(compact('handbookItems'));
    }

    public function companies()
    {
        $companies = SubholdingCompany::where('parent_id', 0)->with('childCompanies')->get()->toArray();
        $companies = json_encode($companies);
        return view('economy_kenzhe.reptt')->with(compact('companies'));
    }

    public function importRepTt(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('economy_kenzhe.import_rep');
        } elseif ($request->isMethod('POST')) {
            Excel::import(new HandbookRepTtValueImport(), $request->select_file);
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
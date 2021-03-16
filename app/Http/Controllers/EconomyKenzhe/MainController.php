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

    public function company($id, $dateFrom, $dateTo)
    {
        $dateTo = date('Y-m-d', strtotime('01-' . $dateTo));
        $dateFrom = date('Y-m-d', strtotime('01-' . $dateFrom));
        $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
        $companyRepTtValues = SubholdingCompany::find($id)->statsByDate($dateFrom,$dateTo)->get()->toArray();
        $repTtReportValues = $this->recursiveSetValueToRepTt($handbook, $companyRepTtValues);
        $repTtReportValues = json_encode($repTtReportValues);
        return view('economy_kenzhe.company')->with(compact('repTtReportValues'));
    }

    public function recursiveSetValueToRepTt(&$items, $companyValues)
    {
        $companyValuesRepTtIds = array_column($companyValues, 'rep_id');
        foreach ($items as $key => $value) {
            if (count($value['handbook_items']) > 0) {
                $this->recursiveSetValueToRepTt($items[$key]['handbook_items'], $companyValues);
            } else {
                $id = $value['id'];
                $k = [];
                $k = array_filter($companyValuesRepTtIds, function ($v, $i) use ($id) {
                    return $v == $id;
                }, ARRAY_FILTER_USE_BOTH);
                if (count($k) > 0) {
                    if (!array_key_exists('values', $items[$key])) {
                        $items[$key]['values'] = [];
                    }
                    foreach ($k as $k => $v) {
                        array_push($items[$key]['values'], $companyValues[$k]);
                    }
                } else {
                    $value['values'] = [];
                    $items[$key] = $value;
                }
            }
        }
        return $items;
    }
    
}

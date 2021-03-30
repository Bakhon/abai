<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Imports\HandbookRepTtTitlesImport;
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
            return view('economy_kenzhe.import_reptt');
        } elseif ($request->isMethod('POST')) {
            Excel::import(new HandbookRepTtValueImport($request->importExcelType), $request->select_file);
            return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

    public function importRepTtTitles(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('economy_kenzhe.import_reptt_titles');
        } elseif ($request->isMethod('POST')) {
            $titles = Excel::toCollection(new HandbookRepTtTitlesImport($request->importExcelType), $request->select_file);
            dd($titles);
            return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

    public function company($id, $dateFrom, $dateTo)
    {
        $dateTo = date('Y-m-d', strtotime('01-' . $dateTo));
        $dateFrom = date('Y-m-d', strtotime('01-' . $dateFrom));
        $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
        $companyRepTtValues = SubholdingCompany::find($id)->statsByDate($dateFrom, $dateTo)->get()->toArray();
        $repTtReportValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues);
        $repTtReportValues = json_encode($repTtReportValues);

        return view('economy_kenzhe.company')->with(compact('repTtReportValues'));
    }

    public function recursiveSetValueToHandbook(&$items, $companyRepTtValues)
    {
        $companyValuesRepTtIds = array_column($companyRepTtValues, 'rep_id');
        foreach ($items as $key => $value) {
            if (!array_key_exists('value', $items[$key])) {
                $items[$key]['value'] = 0;
            }
            if (count($value['handbook_items']) > 0) {
                $this->recursiveSetValueToHandbook($items[$key]['handbook_items'], $companyRepTtValues);
            } else {
                $id = $value['id'];
                $k = array_filter($companyValuesRepTtIds, function ($v, $i) use ($id) {
                    return $v == $id;
                }, ARRAY_FILTER_USE_BOTH);
                if (count($k) > 0) {
                    foreach ($k as $i => $v) {
                        $items[$key]['value'] += abs($companyRepTtValues[$i]['value']);
                    }
                }
            }
        }
        return $items;
    }

    public function recursiveSetValueToHandbookByType(&$items, $companyRepTtValues)
    {
        $companyValuesRepTtIds = array_column($companyRepTtValues, 'rep_id');
        foreach ($items as $key => $value) {
            if (!array_key_exists('plan_value', $items[$key])) {
                $items[$key]['plan_value'] = 0;
            }
            if (!array_key_exists('fact_value', $items[$key])) {
                $items[$key]['fact_value'] = 0;
            }
            if (count($value['handbook_items']) > 0) {
                $this->recursiveSetValueToHandbookByType($items[$key]['handbook_items'], $companyRepTtValues);
            } else {
                $id = $value['id'];
                $k = array_filter($companyValuesRepTtIds, function ($v, $i) use ($id) {
                    return $v == $id;
                }, ARRAY_FILTER_USE_BOTH);
                if (count($k) > 0) {
                    foreach ($k as $i => $v) {
                        if ($companyRepTtValues[$i]['type'] == 'plan') {
                            $items[$key]['plan_value'] += $companyRepTtValues[$i]['value'];
                        } elseif ($companyRepTtValues[$i]['type'] == 'fact') {
                            $items[$key]['fact_value'] += $companyRepTtValues[$i]['value'];
                        }
                    }
                }
            }
        }
        return $items;
    }

}

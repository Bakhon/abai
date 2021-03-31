<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Imports\HandbookRepTtTitlesImport;
use App\Imports\HandbookRepTtValueImport;
use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
//            dd($titles);
            return back()->with('success', 'Загрузка прошла успешно.');
        }
    }

    public function company($id, $dateFrom, $dateTo)
    {
        $currentYear = date('Y', strtotime('01-' .$dateFrom));
        $previousYear = $currentYear-1;
        $dateTo = date('Y-m-d', strtotime('01-' . $dateTo));
        $dateFrom = date('Y-m-d', strtotime('01-' . $dateFrom));
        $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
//        $companyRepTtValues = SubholdingCompany::find($id)->statsByDate($dateFrom, $dateTo)->get()->toArray();
        $companyRepTtValues = SubholdingCompany::find($id)->statsByDate($currentYear)->get()->toArray();
        $repTtReportValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $currentYear, $previousYear);
        $data = [
            'reptt'=> $repTtReportValues,
            'currentYear' =>$currentYear,
            'previousYear'=>$previousYear
        ];
        $data = json_encode($data);

        return view('economy_kenzhe.company')->with(compact('data'));
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

    public function recursiveSetValueToHandbookByType(&$items, $companyRepTtValues, $currentYear, $previousYear)
    {
        $companyValuesRepTtIds = array_column($companyRepTtValues, 'rep_id');
        foreach ($items as $key => $value) {
            if (!array_key_exists('plan_value', $items[$key])) {
                $items[$key]['plan_value'][$currentYear] = 0;
                $items[$key]['plan_value'][$previousYear] = 0;
            }
            if (!array_key_exists('fact_value', $items[$key])) {
                $items[$key]['fact_value'][$currentYear] = 0;
                $items[$key]['fact_value'][$previousYear] = 0;
            }
            if (count($value['handbook_items']) > 0) {
                $this->recursiveSetValueToHandbookByType($items[$key]['handbook_items'], $companyRepTtValues, $currentYear, $previousYear);
            } else {
                $id = $value['id'];
                $k = array_filter($companyValuesRepTtIds, function ($v, $i) use ($id) {
                    return $v == $id;
                }, ARRAY_FILTER_USE_BOTH);
                if (count($k) > 0) {
                    foreach ($k as $i => $v) {
                        if ($companyRepTtValues[$i]['type'] == 'plan') {
                            if(date('Y', strtotime($companyRepTtValues[$i]['date'])) == $currentYear) {
                                $items[$key]['plan_value'][$currentYear] += $companyRepTtValues[$i]['value'];
                            }else{
                                $items[$key]['plan_value'][$previousYear] += $companyRepTtValues[$i]['value'];
                            }
                        } elseif ($companyRepTtValues[$i]['type'] == 'fact') {
                            if(date('Y', strtotime($companyRepTtValues[$i]['date'])) == $currentYear){
                                $items[$key]['fact_value'][$currentYear] += $companyRepTtValues[$i]['value'];
                            }else{
                                $items[$key]['fact_value'][$previousYear] += $companyRepTtValues[$i]['value'];
                            }
                        }
                    }
                }
            }
        }
        return $items;
    }

}

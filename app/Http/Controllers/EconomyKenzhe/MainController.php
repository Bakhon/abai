<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Http\Controllers\Controller;
use App\Models\EcoRefsCompaniesId;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $companyId = 0;
    public $dateTo = null;
    public $dateFrom = null;
    public $defaultCompanyId = 7;

    public function company(Request $request)
    {
        $this->dateTo = date('Y-m-d', strtotime(' -1 year'));
        $this->dateFrom = date("Y-m-d", strtotime($this->dateTo . " -3 months"));

        if ($request->company) {
            $this->companyId = $request->company;
        }else{
            $this->companyId = $this->defaultCompanyId;
        }
        if ($request->betweenMonthsValue) {
            $this->dateFrom = date('Y-m-d', strtotime(date('Y', strtotime($this->dateTo)) . '-01-01'));
            $this->dateTo = date('Y-m-d', strtotime(date('Y', strtotime($this->dateTo)) . '-' . $request->betweenMonthsValue));
        }
        if ($request->monthsValue) {
            $this->dateFrom = date("Y-m-d", strtotime(date('Y', strtotime($this->dateTo)) . '-' . $request->monthsValue . '-01'));
            $this->dateTo = date("Y-m-d", strtotime(date('Y', strtotime($this->dateTo)) . '-' . $request->monthsValue . '-31'));
        }
        if ($request->quarterValue) {
            $this->dateTo = date("Y-m-d", strtotime(date('Y', strtotime($this->dateTo)) . '-' . $request->quarterValue . '-01'));
            $this->dateFrom = date("Y-m-d", strtotime($this->dateTo . " -3 months"));
        }
        $currentYear = date('Y', strtotime($this->dateTo));
        $previousYear = (string) $currentYear - 1;
        $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
        $companies = EcoRefsCompaniesId::all();
        $companyRepTtValues = EcoRefsCompaniesId::find($this->companyId)->statsByDate($currentYear)->get()->toArray();
        $repTtReportValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $currentYear, $previousYear, $this->dateFrom, $this->dateTo);

        $data = [
            'reptt' => $repTtReportValues,
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
            'companies' => $companies,
        ];
        $data = json_encode($data);

        return view('economy_kenzhe.company')->with(compact('data'));
    }

    public function recursiveSetValueToHandbookByType(&$items, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo)
    {
        $companyValuesRepTtIds = array_column($companyRepTtValues, 'rep_id');
        foreach ($items as $repttIndex => $reptt) {
            $handbookKeys = ['plan_value', 'fact_value', 'intermediate_plan_value', 'intermediate_fact_value'];
            foreach ($handbookKeys as $key) {
                $this->setItemsDefaultValue($key, $items[$repttIndex], $currentYear, $previousYear);
            }
            if (count($reptt['handbook_items']) > 0) {
                $this->recursiveSetValueToHandbookByType($items[$repttIndex]['handbook_items'], $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo);
            } else {
                $this->setValueForEqualIdsToitem($companyValuesRepTtIds, $reptt, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo, $items, $repttIndex);
            }
        }
        return $items;
    }


    public function getValuesIdsByRepTtId($companyValuesRepTtIds, $repTt)
    {
        $id = $repTt['id'];
        $ids = array_filter($companyValuesRepTtIds, function ($v) use ($id) {
            return $v == $id;
        }, ARRAY_FILTER_USE_BOTH);
        return $ids;
    }

    public function setItemsDefaultValue($key, &$item, $currentYear, $previousYear)
    {
        if (!array_key_exists($key, $item)) {
            $item[$key][$currentYear] = 0;
            $item[$key][$previousYear] = 0;
        }
    }

    private function setValueForEqualIdsToitem($companyValuesRepTtIds, $reptt, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo, &$items, $repttIndex)
    {
        $equalIds = $this->getValuesIdsByRepTtId($companyValuesRepTtIds, $reptt);
        if (count($equalIds) == 0) {
            return;
        }
        foreach (array_keys($equalIds) as $valIndex) {
            $currentItemDate = strtotime($companyRepTtValues[$valIndex]['date']);
            if ($companyRepTtValues[$valIndex]['type'] == 'plan') {
                if (date('Y', $currentItemDate) == $currentYear) {
                    $this->sumValuesByItemType($items[$repttIndex], 'plan_value', $companyRepTtValues[$valIndex]['value'], $dateFrom, $dateTo, $currentYear, $currentItemDate);
                }
            }
            if ($companyRepTtValues[$valIndex]['type'] == 'fact') {
                if (date('Y', $currentItemDate) == $currentYear) {
                    $this->sumValuesByItemType($items[$repttIndex], 'fact_value', $companyRepTtValues[$valIndex]['value'], $dateFrom, $dateTo, $currentYear, $currentItemDate);
                } else {
                    $this->sumValuesByItemType($items[$repttIndex], 'fact_value', $companyRepTtValues[$valIndex]['value'], $dateFrom . " - 1 year", $dateTo . " - 1 year", $previousYear, $currentItemDate);
                }
            }
        }
    }

    public function sumValuesByItemType(&$item, $attribute, $value, $dateFrom, $dateTo, $year, $currentItemDate)
    {
        $item[$attribute][$year] += (float)$value;
        if (strtotime($dateFrom) <= $currentItemDate && strtotime($dateTo) >= $currentItemDate) {
            $item['intermediate_' . $attribute][$year] += (float)$value;
        }
    }
}

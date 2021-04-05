<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;
use App\Http\Controllers\Controller;

class MainController extends Controller
{

    public function company()
    {
        $companyId = 116;
        $dateTo = date('Y-m-d', strtotime('-1 year'));
        $dateFrom = date("Y-m-d", strtotime($dateTo . "-3 months"));
        $currentYear = date('Y', strtotime('-1 year'));
        $previousYear = (string)$currentYear - 1;
        $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
        $companyRepTtValues = SubholdingCompany::find($companyId)->statsByDate($currentYear)->get()->toArray();
        $repTtReportValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo);
        $data = [
            'reptt' => $repTtReportValues,
            'currentYear' => $currentYear,
            'previousYear' => $previousYear
        ];
        $data = json_encode($data);
        return view('economy_kenzhe.company')->with(compact('data'));
    }

    public function recursiveSetValueToHandbookByType(&$items, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo)
    {
        $companyValuesRepTtIds = array_column($companyRepTtValues, 'rep_id');
        foreach ($items as $repttIndex => $reptt) {
            $this->isKeyExists('plan_value', $items[$repttIndex], $currentYear, $previousYear);
            $this->isKeyExists('fact_value', $items[$repttIndex], $currentYear, $previousYear);
            $this->isKeyExists('intermediate_plan_value', $items[$repttIndex], $currentYear, $previousYear);
            $this->isKeyExists('intermediate_fact_value', $items[$repttIndex], $currentYear, $previousYear);
            if (count($reptt['handbook_items']) <= 0) {
                $equalIds = $this->getValuesIdsByRepTtId($companyValuesRepTtIds, $reptt);
                if (count($equalIds) <= 0) {
                    continue;
                }
                $this->setValuesByType($equalIds, $items, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo, $repttIndex);

            } else {
                $this->recursiveSetValueToHandbookByType($items[$repttIndex]['handbook_items'], $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo, $repttIndex);
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

    public function isKeyExists($key, &$item, $currentYear, $previousYear)
    {
        if (!array_key_exists($key, $item)) {
            $item[$key][$currentYear] = 0;
            $item[$key][$previousYear] = 0;
        }
    }

    public function setValuesByType($equalIds, &$items, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo, $repttIndex)
    {
        foreach ($equalIds as $i => $v) {
            $currentItemDate = strtotime($companyRepTtValues[$i]['date']);
            if ($companyRepTtValues[$i]['type'] == 'plan') {
                if (date('Y', $currentItemDate) == $currentYear) {
                    $items[$repttIndex]['plan_value'][$currentYear] += $companyRepTtValues[$i]['value'];
                    if (strtotime($dateFrom) <= $currentItemDate && strtotime($dateTo) >= $currentItemDate) {
                        $items[$repttIndex]['intermediate_plan_value'][$currentYear] += $companyRepTtValues[$i]['value'];
                    }
                }
            }
            if ($companyRepTtValues[$i]['type'] == 'fact') {
                if (date('Y', $currentItemDate) == $currentYear) {
                    $items[$repttIndex]['fact_value'][$currentYear] += $companyRepTtValues[$i]['value'];
                    if (strtotime($dateFrom) <= $currentItemDate && strtotime($dateTo) >= $currentItemDate) {
                        $items[$repttIndex]['intermediate_fact_value'][$currentYear] += $companyRepTtValues[$i]['value'];
                    }
                } else {
                    $items[$repttIndex]['fact_value'][$previousYear] += $companyRepTtValues[$i]['value'];
                    if (strtotime($dateFrom . " - 1 year") <= $currentItemDate && strtotime($dateTo . " - 1 year") >= $currentItemDate) {
                        $items[$repttIndex]['intermediate_fact_value'][$previousYear] += $companyRepTtValues[$i]['value'];
                    }
                }
            }
        }
    }
}

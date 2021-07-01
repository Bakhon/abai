<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\HandbookRepTtValue;
use App\Http\Controllers\Controller;
use App\Models\EcoRefsCompaniesId;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $companyId = 7;
    public $dateTo = null;
    public $dateFrom = null;
    public $parentId = [
        'B71000000000' => 0,
        'B60102990097' => 0,
        'B70101990097' => 0,
        'B72000000000' => 0,
        'B73000000000' => 0,
        'B74000000000' => 0,
        'B91110301000' => 0,
        'B77000000000' => 0,
        'BZF402010000' => 0,
        'B77001010000' => 0,
        'B77001020000' => 0,
        'B77001030000' => 0,
        'B77001040000' => 0,
        'B61001000000' => 0,
        'B61012000000' => 0,
        'B61099450000' => 0,
        'B61099460000' => 0,
        'B61099470000' => 0,
        'B61099990000' => 0,
        'B61099990097' => 0,
        'B61099480000' => 0,
        'B61099490000' => 0,
        'B77002000000' => 0,
        'B77001000000' => 0,
    ];
    public $sum = [
        'B71000000000' => 0,
        'B60102990097' => 0,
        'B70101990097' => 0,
        'B72000000000' => 0,
        'B73000000000' => 0,
        'B74000000000' => 0,
        'B91110301000' => 0,
        'B77000000000' => 0,
        'BZF402010000' => 0,
        'B77001010000' => 0,
        'B77001020000' => 0,
        'B77001030000' => 0,
        'B77001040000' => 0,
        'B61001000000' => 0,
        'B61012000000' => 0,
        'B61099450000' => 0,
        'B61099460000' => 0,
        'B61099470000' => 0,
        'B61099990000' => 0,
        'B61099990097' => 0,
        'B61099480000' => 0,
        'B61099490000' => 0,
        'B77002000000' => 0,
        'B77001000000' => 0,
    ];

    public function company(Request $request)
    {
        $currentYear = date('Y', strtotime('-1 year'));
        $previousYear = (float) $currentYear - 1;
        $this->dateFrom = date('Y-m-d', strtotime('first day of january previous year'));
        $this->dateTo = date('Y-m-d', strtotime('last day of december previous year'));
        if($request->company) {
            $this->companyId = $request->company;
        }
        if($request->monthsValue && $request->monthsValue != '00' ) {
            $this->dateFrom = date('Y-m-d', mktime(0, 0, 0, $request->monthsValue, 1, $currentYear));
            $this->dateTo = date("Y-m-d", strtotime($this->dateFrom . " +1 months"));
        }
        if($request->differenceBetweenMonths && $request->differenceBetweenMonths != '01') {
            $this->dateFrom = date('Y-m-d', strtotime('first day of january previous year'));
            $this->dateTo = date('Y-m-d', mktime(0, 0, 0, $request->differenceBetweenMonths, 1, $currentYear));
        }
        if($request->quarterValue && $request->quarterValue != '01') {
            $this->dateTo  = date('Y-m-t', mktime(0, 0, 0, $request->quarterValue, 1, $currentYear));
            $this->dateFrom = date('Y-m-01', strtotime($this->dateTo . '-2 months'));
        }
        $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
        $companies = EcoRefsCompaniesId::all();
        $companyRepTtValues = EcoRefsCompaniesId::find($this->companyId)->statsByDate($currentYear)->get()->toArray();
        $repTtReportValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $currentYear, $previousYear, $this->dateFrom, $this->dateTo);
        $repTtReportValues = $this->setNetProfitValues($repTtReportValues, $currentYear, $previousYear);
        $data = [
            'reptt' => $repTtReportValues,
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
            'companies' => $companies,
        ];

        return json_encode($data);
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

    public function setNetProfitValues(array &$items, int $currentYear, int $previousYear): array
    {
        $handbookKeys = ['plan_value', 'fact_value', 'intermediate_plan_value', 'intermediate_fact_value'];
        foreach ($items as &$item) {
            foreach ($handbookKeys as $handbookKey) {
                foreach ([$currentYear, $previousYear] as $year) {
                    if ($item['num'] == 'B91000000000') {
                        $item[$handbookKey][$year] =
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B60102990097') -
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B70101990097') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B71000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B72000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B73000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B74000000000') +
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B91110301000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B77001000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B77002000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'BZF402010000');
                    }
                    if ($item['num'] == 'B91110101000') {
                        $item[$handbookKey][$year] =
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B60102990097') -
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B70101990097');
                    }
                    if ($item['num'] == 'B91110100000') {
                        $item[$handbookKey][$year] =
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B60102990097') -
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B70101990097') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B71000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B72000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B73000000000');
                    }
                    if ($item['num'] == 'B91110000000') {
                        $item[$handbookKey][$year] =
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B60102990097') -
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B70101990097') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B71000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B72000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B73000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B74000000000') +
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B91110301000');
                    }
                    if ($item['num'] == 'B91100000000') {
                        $item[$handbookKey][$year] =
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B60102990097') -
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B70101990097') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B71000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B72000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B73000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B74000000000') +
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B91110301000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B77001000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B77002000000');
                    }
                }
            }
        }
        return $items;
    }

    public function getSumValuesByNum(array $items, string $type, int $year, string $num)
    {
        foreach ($items as $item) {
            if ($item['handbook_items']) {
                return $this->getSumValuesByNum($item['handbook_items'], $type, $year, $num);
            }
            if ($item['num'] == $num) {
                return $item[$type][$year];
            }
        }

    }

    public function getSumValuesByParentId(array $items,string $type, int $year, string $num)
    {
        if (!$this->parentId[$num]) {
            $this->parentId[$num] = HandbookRepTt::select('id')->where('num', $num)->first()['id'];
        }
        if (!$this->sum[$num]) {
            foreach ($items as $item) {
                if ($item['handbook_items']) {
                    $this->getSumValuesByParentId($item['handbook_items'], $type, $year, $num);
                }
                if ($item['parent_id'] == $this->parentId[$num]) {
                    $this->sum[$num] -= (float)$item[$type][$year];
                }
            }
        }
        return $this->sum[$num];
    }
}



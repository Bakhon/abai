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
    public $dateTo;
    public $dateFrom;
    public $opiuIds = [
        'B71000000000', 'B60102990097', 'B70101990097',
        'B72000000000', 'B73000000000', 'B74000000000',
        'B91110301000', 'B77000000000', 'BZF402010000',
        'B77001010000', 'B77001020000', 'B77001030000',
        'B77001040000', 'B61001000000', 'B61012000000',
        'B61099450000', 'B61099460000', 'B61099470000',
        'B61099990000', 'B61099990097', 'B61099480000',
        'B61099490000', 'B77002000000', 'B77001000000'
    ];
    public $opiuNum = [
        'netIncome' => 'B91000000000',
        'grossIncome' => 'B91110101000',
        'operatingProfit' => 'B91110100000',
        'beforeTaxIncome' => 'B91110000000',
        'beforeMinorityShareIncome' => 'B91100000000',
    ];
    public $parentId = [];
    public $sum = [];
    public $handbookKeys = ['plan_value', 'fact_value', 'intermediate_plan_value', 'intermediate_fact_value'];
    public $sumByNum;
    public $handbook;
    public $companies;
    public $companyRepTtValues;
    public $currentYear;
    public $previousYear;

    public function __construct()
    {
        $this->sum = array_fill_keys($this->opiuIds, 0);
        $this->parentId = array_fill_keys($this->opiuIds, []);
        $this->dateFrom = date('Y-m-d', strtotime('first day of january previous year'));
        $this->dateTo = date('Y-m-d', strtotime('last day of december previous year'));
        $this->previousYear = date('Y', strtotime('-1 year'));
        $this->beforePreviousYear = (int)$this->previousYear - 1;
    }

    public function company(Request $request): string
    {
        $this->dateFilter($request);
        $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
        $companies = EcoRefsCompaniesId::all();
        $companyRepTtValues = EcoRefsCompaniesId::find($this->companyId)->statsByDate($this->currentYear)->get()->toArray();
        $repTtReportValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $this->previousYear, $this->beforePreviousYear, $this->dateFrom, $this->dateTo);
        $data = [
            'reptt' => $this->setNetProfitValues($repTtReportValues, $this->previousYear, $this->beforePreviousYear),
            'currentYear' => $this->previousYear,
            'previousYear' => $this->beforePreviousYear,
            'companies' => $companies,
        ];

        return json_encode($data);
    }

    public function dateFilter(Request $request): void
    {
        if ($request->company) {
            $this->companyId = $request->company;
        }
        if ($request->monthsValue && $request->monthsValue != '00') {
            $this->dateFrom = date('Y-m-d', mktime(0, 0, 0, $request->monthsValue, 1, $this->currentYear));
            $this->dateTo = date("Y-m-d", strtotime($this->dateFrom . " +1 months"));
        }
        if ($request->differenceBetweenMonths && $request->differenceBetweenMonths != '01') {
            $this->dateFrom = date('Y-m-d', strtotime('first day of january previous year'));
            $this->dateTo = date('Y-m-d', mktime(0, 0, 0, $request->differenceBetweenMonths, 1, $this->currentYear));
        }
        if ($request->quarterValue && $request->quarterValue != '01') {
            $this->dateTo = date('Y-m-t', mktime(0, 0, 0, $request->quarterValue, 1, $this->currentYear));
            $this->dateFrom = date('Y-m-01', strtotime($this->dateTo . '-2 months'));
        }
    }

    public function recursiveSetValueToHandbookByType(array &$items, array $companyRepTtValues, int $currentYear, int $previousYear, string $dateFrom, string $dateTo): array
    {
        $companyValuesRepTtIds = array_column($companyRepTtValues, 'rep_id');
        foreach ($items as $repttIndex => $reptt) {
            foreach ($this->handbookKeys as $key) {
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


    public function getValuesIdsByRepTtId(array $companyValuesRepTtIds, array $repTt): array
    {
        $id = $repTt['id'];
        $ids = array_filter($companyValuesRepTtIds, function ($v) use ($id) {
            return $v == $id;
        }, ARRAY_FILTER_USE_BOTH);
        return $ids;
    }

    public function setItemsDefaultValue(string $key, array &$item, int $currentYear, int $previousYear): void
    {
        if (!array_key_exists($key, $item)) {
            $item[$key][$currentYear] = 0;
            $item[$key][$previousYear] = 0;
        }
    }

    private function setValueForEqualIdsToitem(array $companyValuesRepTtIds, array $reptt, array $companyRepTtValues, int $currentYear, int $previousYear, string $dateFrom, string $dateTo, array &$items, string $repttIndex): void
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

    public function sumValuesByItemType(array &$item, string $attribute, string $value, string $dateFrom, string $dateTo, int $year, string $currentItemDate): void
    {
        $item[$attribute][$year] += (int)$value;
        if (strtotime($dateFrom) <= $currentItemDate && strtotime($dateTo) >= $currentItemDate) {
            $item['intermediate_' . $attribute][$year] += (int)$value;
        }
    }

    public function setNetProfitValues(array &$items, int $currentYear, int $previousYear): array
    {
        foreach ($items as &$item) {
            foreach ($this->handbookKeys as $handbookKey) {
                foreach ([$currentYear, $previousYear] as $year) {
                    if ($item['num'] == $this->opiuNum['netIncome']) {
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
                    if ($item['num'] == $this->opiuNum['grossIncome']) {
                        $item[$handbookKey][$year] =
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B60102990097') -
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B70101990097');
                    }
                    if ($item['num'] == $this->opiuNum['operatingProfit']) {
                        $item[$handbookKey][$year] =
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B60102990097') -
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B70101990097') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B71000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B72000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B73000000000');
                    }
                    if ($item['num'] == $this->opiuNum['beforeTaxIncome']) {
                        $item[$handbookKey][$year] =
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B60102990097') -
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B70101990097') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B71000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B72000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B73000000000') -
                            $this->getSumValuesByParentId($items, $handbookKey, $year, 'B74000000000') +
                            $this->getSumValuesByNum($items, $handbookKey, $year, 'B91110301000');
                    }
                    if ($item['num'] == $this->opiuNum['beforeMinorityShareIncome']) {
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

    public function getSumValuesByNum(array $items, string $type, int $year, string $num): int
    {
        foreach ($items as $item) {
            if ($item['handbook_items']) {
                $this->getSumValuesByNum($item['handbook_items'], $type, $year, $num);
            }
            if ($item['num'] == $num) {
                $this->sumByNum = (int)$item[$type][$year];
            }
        }
        return $this->sumByNum;
    }

    public function getSumValuesByParentId(array $items, string $type, int $year, string $num): int
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
                    $this->sum[$num] -= (int)$item[$type][$year];
                }
            }
        }
        return $this->sum[$num];
    }
}



<?php

namespace App\Http\Controllers\VisCenter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VisCenter\ImportForms\DZOyearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DzoPlan;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;

class OilDynamic extends Controller
{
    private $dzoName;
    private $monthNumber;
    private $factField;
    private $planField;
    private $fields = array(
        'factDay',
        'planDay',
        'planMonth',
        'factMonth',
        'factYear',
        'planYear'
    );
    private $allCategories = array (
        'ЭМГ' => array (
            'dzo' => array ('ЭМГ'),
            'fact' => array ('oil_production_fact'),
            'plan' => array ('plan_oil')
        ),
        'КОА' => array (
             'dzo' => array ('КОА'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'КТМ' => array (
             'dzo' => array ('КТМ'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'КБМ' => array (
             'dzo' => array ('КБМ'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'КГМ' => array (
            'dzo' => array ('КГМ'),
            'fact' => array ('oil_production_fact'),
            'plan' => array ('plan_oil')
        ),
        'ММГ' => array (
             'dzo' => array ('ММГ'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'ОМГ' => array (
             'dzo' => array ('ОМГ'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'ОМГК' => array (
             'dzo' => array ('ОМГ'),
             'fact' => array ('condensate_production_fact'),
             'plan' => array ('plan_kondensat')
         ),
        'УО' => array (
             'dzo' => array ('УО'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'АГ' => array (
             'dzo' => array ('АГ'),
             'fact' => array ('condensate_production_fact'),
             'plan' => array ('plan_kondensat')
         ),
        'ПКИ' => array (
            'dzo' => array ('ПКК','КГМ','ТП'),
            'fact' => array ('oil_production_fact'),
            'plan' => array ('plan_oil'),
            'multiplier' => array (
                'ПКК' => 3.03,
                'КГМ' => 2,
                'ТП' => 2
            )
        ),
        'ПКК' => array (
             'dzo' => array ('ПКК'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'ТП' => array (
             'dzo' => array ('ТП'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'КПО' => array (
             'dzo' => array ('КПО'),
             'fact' => array ('oil_production_fact'),
             'plan' => array ('plan_oil')
         ),
        'НКО' => array (
           'dzo' => array ('НКО'),
           'fact' => array ('oil_production_fact'),
           'plan' => array ('plan_oil')
        ),
        'РД КМГ' => array (
            'dzo' => array ('ОМГ','ЭМГ'),
            'fact' => array ('oil_production_fact'),
            'plan' => array ('plan_oil')
        )
    );

    public function oilDynamic()
    {
        return view('visualcenter.oil_dynamic');
    }

    public function getDailyProductionData(Request $request)
    {
        $this->monthNumber = $request->month;
        return $this->getSummaryByCategories();
    }

    private function getSummaryByCategories()
    {
        $summary = array();
        foreach($this->allCategories as $category => $item) {
            $summary[$category] = $this->getSummaryByCategory($item,$category);
        }
        return $summary;
    }

    private function getSummaryByCategory($item,$category)
    {
        $this->dzoName = $item['dzo'];
        $this->factField = $item['fact'];
        $this->planField = $item['plan'];
        $dailyFact = $this->getDailyFact();
        $dailyPlan = $this->getDailyPlan();
        $yearlyData = $this->getYearly();
        $dailyCompared = $this->getCompared($dailyFact,$dailyPlan,$item,$category);
        return $this->getMonthly($dailyCompared,$yearlyData);
    }

    private function getDailyFact()
    {
        return DzoImportData::query()
            ->select('date','dzo_name')
            ->addSelect($this->factField)
            ->whereNull('is_corrected')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', $this->monthNumber)
            ->whereIn('dzo_name',$this->dzoName)
            ->orderBy('date', 'ASC')
            ->get();
    }

    private function getDailyPlan()
    {
        return DzoPlan::query()
            ->select('date','dzo')
            ->addSelect($this->planField)
            ->whereMonth('date', $this->monthNumber)
            ->whereYear('date', Carbon::now()->year)
            ->whereIn('dzo',$this->dzoName)
            ->get();
    }

    private function getCompared($fact,$plan,$dzoParams,$category)
    {
        $compared = array();
        $planFields = $this->planField;
        foreach($fact as $dayFact) {
            $filteredPlan = $plan->where('dzo',$dayFact['dzo_name']);
            $dailyPlan = $filteredPlan->sum(function ($row) use ($planFields) {
                $summary = 0;
                foreach($planFields as $field) {
                    $summary += $row->$field;
                };
                return $summary;
            });
            $dayRecord = array (
                 'name' => $dayFact['dzo_name'],
                 'date' => Carbon::parse($dayFact['date'])->format('d.m.Y'),
                 'factDay' => $this->getSummaryByFields($dayFact,$this->factField),
                 'planDay' => $dailyPlan,
                 'planMonth' => 0,
                 'factMonth' => 0,
                 'factYear' => 0,
                 'planYear' => 0
            );
            if (array_key_exists('multiplier',$dzoParams)) {
               $dayRecord = $this->getUpdatedByMultiplier($dayRecord,$dzoParams['multiplier']);
               $dayRecord['name'] = $category;
            }
            array_push($compared,$dayRecord);
        }
        if (count($this->dzoName) > 1) {
            $groupedByDate = array();
            foreach ($compared as $key => $item) {
               $groupedByDate[$item['date']][$key] = $item;
            }
            return $this->getSummary($groupedByDate,$category);
        }
        return $compared;
    }

    private function getSummaryByFields($data,$fields)
    {
        $summary = 0;
        foreach($fields as $field) {
            $summary += $data->$field;
        };
        return $summary;
    }

    private function getUpdatedByMultiplier($dayRecord,$multiplier)
    {
        $multipliedRecord = $dayRecord;
        foreach($this->fields as $field) {
            $multipliedRecord[$field] /= $multiplier[$multipliedRecord['name']];
        }
        return $multipliedRecord;
    }

    private function getSummary($grouped,$category)
    {
        $summary = array();
        foreach($grouped as $date => $item) {
            $daySummary = array(
                'name' => $category,
                'date' => $date
            );
            foreach($this->fields as $field) {
                $daySummary[$field] = array_sum(array_column($item, $field));
            }
            array_push($summary,$daySummary);
        }
        return $summary;
    }

    private function getMonthly($dailyData,$yearlyData)
    {
        $monthlyData = array();
        $previousData = $dailyData[0];
        $previousData['factYear'] = $yearlyData['factYear'];
        $previousData['planYear'] = $yearlyData['planYear'];
        foreach($dailyData as $dayData) {
            $summary = $previousData;
            $summary['date'] = $dayData['date'];
            $summary['planDay'] = $dayData['planDay'];
            $summary['factDay'] = $dayData['factDay'];
            $summary['planMonth'] += $dayData['planDay'];
            $summary['factMonth'] += $dayData['factDay'];
            $summary['planYear'] += $dayData['planDay'];
            $summary['factYear'] += $dayData['factDay'];
            $previousData = $summary;
            array_push($monthlyData,$summary);
        }
        return $monthlyData;
    }

    private function getYearly()
    {
        $yearlyFact = $this->getYearlyFact();
        $yearlyPlan = $this->getYearlyPlan();
        return array(
            'planYear' => $yearlyPlan,
            'factYear' => $yearlyFact
        );
    }

    private function getYearlyFact()
    {
        $factFields = $this->factField;
        return DzoImportData::query()
            ->select('date')
            ->addSelect($this->factField)
            ->whereNull('is_corrected')
            ->whereMonth('date', '<', $this->monthNumber)
            ->whereYear('date', Carbon::now()->year)
            ->whereIn('dzo_name',$this->dzoName)
            ->get()
            ->sum(function ($row) use ($factFields) {
                $summary = 0;
                foreach($factFields as $field) {
                    $summary += $row->$field;
                };
                return $summary;
            });
    }

    private function getYearlyPlan()
    {
        $yearlyPlans = DzoPlan::query()
            ->select('date','dzo')
            ->addSelect($this->planField)
            ->whereMonth('date', '<', $this->monthNumber)
            ->whereYear('date', Carbon::now()->year)
            ->whereIn('dzo',$this->dzoName)
            ->get();
        $summaryPlan = $this->getSummaryPlan($yearlyPlans);
        return $summaryPlan;
    }

    private function getSummaryPlan($yearlyPlans)
    {
        $summary = 0;
        foreach($yearlyPlans as $monthlyPlan) {
            $daysInMonth = Carbon::parse($monthlyPlan['date'])->daysInMonth;
            foreach($this->planField as $field) {
                $summary += $monthlyPlan[$field] * $daysInMonth;
            }
        }
        return $summary;
    }

}
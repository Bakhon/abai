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
    private $consolidatedDzo = array(
        'ПКИ' => array ('ПКК','КГМ','ТП')
    );
    private $pkiMultiplier = array(
        'ПКК' => 3.03,
        'КГМ' => 2,
        'ТП' => 2,
        'summary' => 0.33
    );
    private $fields = array(
        'factDay',
        'planDay',
        'planMonth',
        'factMonth',
        'factYear',
        'planYear'
    );
    private $isConsolidated = false;
    private $selectedCategory;

    public function oilDynamic()
    {
        return view('visualcenter.oil_dynamic');
    }

    public function getDailyProductionData(Request $request)
    {
        $this->selectedCategory = $request->dzo;
        $this->dzoName = array($request->dzo);
        if (array_key_exists($request->dzo,$this->consolidatedDzo)) {
            $this->dzoName = $this->consolidatedDzo[$request->dzo];
            $this->isConsolidated = true;
        }
        $this->monthNumber = $request->month;
        $this->factField = $request->factField;
        $this->planField = $request->planField;

        $dailyFact = $this->getDailyFact();
        $dailyPlan = $this->getDailyPlan();
        $yearlyData = $this->getYearly();
        $dailyCompared = $this->getCompared($dailyFact,$dailyPlan);
        $monthlyData = $this->getMonthly($dailyCompared,$yearlyData);
        return array (
            'tableData' => $monthlyData,
            'yearlyData' => $yearlyData
        );
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

    private function getCompared($fact,$plan)
    {
        $compared = array();
        foreach($fact as $dayFact) {
            $filteredPlan = $plan->where('dzo',$dayFact['dzo_name']);
            $dailyPlan = $filteredPlan->sum($this->planField);
            $dayRecord = array (
                 'name' => $dayFact['dzo_name'],
                 'date' => Carbon::parse($dayFact['date'])->format('d.m.Y'),
                 'factDay' => $dayFact[$this->factField],
                 'planDay' => $dailyPlan,
                 'planMonth' => 0,
                 'factMonth' => 0,
                 'factYear' => 0,
                 'planYear' => 0
            );
            if ($this->isConsolidated) {
               $dayRecord = $this->getUpdatedByMultiplier($dayRecord);
            }
            array_push($compared,$dayRecord);
        }
        if ($this->isConsolidated) {
            $groupedByDate = array();
            foreach ($compared as $key => $item) {
               $groupedByDate[$item['date']][$key] = $item;
            }
            return $this->getSummary($groupedByDate);
        }
        return $compared;
    }

    private function getUpdatedByMultiplier($dayRecord)
    {
        $multipliedRecord = $dayRecord;
        foreach($this->fields as $field) {
            $multipliedRecord[$field] /= $this->pkiMultiplier[$multipliedRecord['name']];
        }
        return $multipliedRecord;
    }

    private function getSummary($grouped)
    {
        $summary = array();
        foreach($grouped as $date => $item) {

            $daySummary = array(
                'name' => $this->selectedCategory,
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
        return DzoImportData::query()
            ->select('date')
            ->addSelect($this->factField)
            ->whereNull('is_corrected')
            ->whereMonth('date', '<', $this->monthNumber)
            ->whereYear('date', Carbon::now()->year)
            ->where('dzo_name',$this->dzoName)
            ->sum($this->factField);
    }

    private function getYearlyPlan()
    {
        $yearlyPlans = DzoPlan::query()
            ->select('date')
            ->addSelect($this->planField)
            ->whereMonth('date', '<', $this->monthNumber)
            ->whereYear('date', Carbon::now()->year)
            ->where('dzo',$this->dzoName)
            ->get();
        $summaryPlan = $this->getSummaryPlan($yearlyPlans);
        return $summaryPlan;
    }

    private function getSummaryPlan($yearlyPlans)
    {
        $summary = 0;
        foreach($yearlyPlans as $monthlyPlan) {
            $daysInMonth = Carbon::parse($monthlyPlan['date'])->daysInMonth;
            $summary += $monthlyPlan[$this->planField] * $daysInMonth;
        }
        return $summary;
    }

}
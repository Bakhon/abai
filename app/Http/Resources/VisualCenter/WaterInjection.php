<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;

class WaterInjection {
    private $companies = array('ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА');
    private $fieldsMapping = array (
        'waterInjection' => array(
            'fact' => 'agent_upload_total_water_injection_fact',
            'plan' => 'plan_liq'
        ),
        'seaWaterInjection' => array(
            'fact' => 'agent_upload_seawater_injection_fact',
            'plan' => 'plan_liq_ocean'
        ),
        'wasteWaterInjection' => array(
            'fact' => 'agent_upload_waste_water_injection_fact',
            'plan' => 'plan_liq_waste'
        ),
        'artezianWaterInjection' => array(
            'fact' => 'agent_upload_albsenomanian_water_injection_fact',
            'plan' => 'plan_liq_albsen'
        ),
        'streamWaterInjection' => array(
            'fact' => 'agent_upload_stream_injection_fact',
            'plan' => 'plan_par'
        ),
        'volgaWaterInjection' => array(
            'fact' => 'agent_upload_volga_water_injection_fact',
            'plan' => 'plan_liq_voljsk'
        )
    );
    private $decreaseReasonFields = array (
        'daily_reason_1_explanation',
        'daily_reason_2_explanation',
        'daily_reason_3_explanation',
        'daily_reason_4_explanation',
        'daily_reason_5_explanation'
    );

    public function getDataByCategory($factData,$planData,$periodRange,$yearlyPlan,$periodType,$oneDzoSelected)
    {
        if (!is_null($oneDzoSelected)) {
            $this->companies = array();
            $this->companies[] = $oneDzoSelected;
        }
        $factData = $factData->filter(function($item) {
            return in_array($item->dzo_name,$this->companies);
        });
        $groupedFact = $factData->groupBy('dzo_name');
        if ($periodRange === 0 && is_null($oneDzoSelected)) {
            $groupedFact = $this->getUpdatedByMissingCompanies($groupedFact);
        }
        $summaryByCategories = array();
        foreach($this->fieldsMapping as $subcategory => $fields) {
            $summaryByCategories[$subcategory] = $this->getDataBySubCategory($groupedFact,$planData,$periodType,$yearlyPlan,$fields);
        }
        return $summaryByCategories;
    }

    private function getUpdatedByMissingCompanies($groupedFact)
    {
        $updatedByMissingCompanies = $groupedFact;
        $presentCompanies = array_keys($updatedByMissingCompanies->toArray());
        $missingCompanies = array_diff($this->companies, $presentCompanies);
        foreach($missingCompanies as $dzoName) {
            $missingData = $this->getMissingCompanyData($dzoName);
            $updatedByMissingCompanies->put($dzoName,$missingData);
        }
        return $updatedByMissingCompanies;
    }

    private function getMissingCompanyData($dzoName)
    {
        return DzoImportData::query()
             ->where('dzo_name',$dzoName)
             ->whereNull('is_corrected')
             ->with('importDecreaseReason')
             ->latest('date')
             ->take(1)
             ->get();
    }

    private function getDataBySubCategory($groupedFact,$planData,$periodType,$yearlyPlan,$fields)
    {
        $summary = array();
        foreach($groupedFact as $dzoName => $dzoFact) {
            $factDates = array();
            foreach($dzoFact as $dayFact) {
                array_push($factDates,Carbon::parse($dayFact->date)->copy()->firstOfMonth()->format('d.m.Y'));
            }

            if (!is_array($dzoFact)) {
                $dzoFact = $dzoFact->toArray();
            }

            $filteredPlan = $planData->filter(function($item) use($dzoName,$factDates) {
                return in_array(Carbon::parse($item->date)->firstOfMonth()->format('d.m.Y'),$factDates) && $item->dzo === $dzoName;
            })->toArray();
            if (count($filteredPlan) === 0) {
                continue;
            }
            $updated = $this->getData($dzoName,$dzoFact,$filteredPlan,$periodType,$yearlyPlan,$fields);
            if (count($updated) > 0) {
                $summary = array_merge($summary,$updated);
            }
        }
        $sorted = $this->getSortedById($summary);
        return $sorted;
    }

    private function getData($dzo,$dzoFact,$filteredPlan,$periodType,$yearlyPlan,$categoryFields)
    {
        $filteredYearlyPlan = $yearlyPlan->where('dzo',$dzo);
        $daysInMonth = Carbon::parse($dzoFact[0]['date'])->daysInMonth;
        $summary = array();
        $companySummary = array(
           'id' => '1.',
           'name' => $dzo,
           'fact' => array_sum(array_column($dzoFact,$categoryFields['fact'])),
           'plan' => array_sum(array_column($filteredPlan,$categoryFields['plan'])),
           'decreaseReasonExplanations' => [],
        );
        if ($periodType === 'day') {
            $companySummary['decreaseReasonExplanations'] = $this->getAccidentDescription($dzoFact);
        }
        if ($periodType === 'month') {
            $companySummary['monthlyPlan'] = array_column($filteredPlan,$categoryFields['plan'])[0] * $daysInMonth;
           // $companySummary['plan'] *= Carbon::now()->day - 1;
        }
        if ($periodType === 'year') {
            $companySummary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$categoryFields['plan']);
            $companySummary['plan'] = $this->getCurrentPlanForYear($filteredPlan,$categoryFields['plan']);
        }
        if ($companySummary['plan'] + $companySummary['fact'] < 1) {
            return $summary;
        }
        array_push($summary,$companySummary);
        return $summary;
    }

    private function getAccidentDescription($dzoFact)
    {
        $accidents = array();
        $dzoFactData = $dzoFact[0];
        foreach($this->decreaseReasonFields as $fieldName) {
            if (!is_null($dzoFactData['import_decrease_reason']) && isset($dzoFactData['import_decrease_reason'][$fieldName])) {
               array_push($accidents,$dzoFactData['import_decrease_reason'][$fieldName]);
            }
        }
        return $accidents;
    }

    private function getYearlyPlanBy($yearlyPlan,$fieldName)
    {
        $summary = 0;
        foreach($yearlyPlan as $monthly) {
            $summary += $monthly[$fieldName] * Carbon::parse($monthly['date'])->daysInMonth;
        }
        return $summary;
    }

    private function getCurrentPlanForYear($filteredPlan,$fieldName)
    {
        $summaryPlan = 0;
        foreach($filteredPlan as $monthlyPlan) {
            if (Carbon::parse($monthlyPlan['date'])->month < Carbon::now()->month) {
                $summaryPlan += $monthlyPlan[$fieldName] * Carbon::parse($monthlyPlan['date'])->daysInMonth;
            }
            if (Carbon::parse($monthlyPlan['date'])->month === Carbon::now()->month) {
                $summaryPlan += $monthlyPlan[$fieldName] * Carbon::now()->day - 1;
            }
        }
        return $summaryPlan;
    }

    private function getSortedById($data)
    {
        $ordered = array();
        foreach($this->companies as $value) {
            $key = array_search($value, array_column($data, 'name'));
            if ($key !== false) {
                array_push($ordered,$data[$key]);
            }
        }
        return $ordered;
    }

    public function getChartData($fact,$plan,$dzoName,$type)
    {
        $companies = $this->companies;
        if (!is_null($dzoName)) {
            $fact = $fact->filter(function($item) use($dzoName) {
                return $item->dzo_name === $dzoName;
            });
        } else {
            $fact = $fact->filter(function($item) use($companies) {
                return in_array($item->dzo_name,$companies);
            });
        }
        $chartData = array();
        $formattedPlan = array();
        foreach($plan as $item) {
            $date = Carbon::parse($item['date'])->format('d/m/Y');
            $formattedPlan[$date][$item['dzo']] = $item->toArray();
        }
        $factField = $this->fieldsMapping[$type]['fact'];
        $planField = $this->fieldsMapping[$type]['plan'];
        foreach($fact as $item) {
            $date = Carbon::parse($item['date'])->startOfDay()->format('d/m/Y');
            $daySummary = array();
            $formattedDate = Carbon::parse($item['date'])->copy()->firstOfMonth()->startOfDay()->format('d/m/Y');
            $dzoName = $item['dzo_name'];
            $planRecord = $formattedPlan[$formattedDate][$dzoName];
            $daySummary['fact'] = $item[$factField];
            $daySummary['plan'] = $planRecord[$planField];
            $daySummary['date'] = $date;
            $daySummary['name'] = $dzoName;
            array_push($chartData,$daySummary);
        }
        return $chartData;
    }
}
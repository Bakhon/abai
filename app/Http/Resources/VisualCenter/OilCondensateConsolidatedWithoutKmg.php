<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;

class OilCondensateConsolidatedWithoutKmg {
    private $consolidatedNumberMapping = array (
        'oilCondensateProductionWithoutKMG' => array (
            "ОМГ" => "2.1.",
            "ОМГК" => "",
            "ММГ" => "2.2.",
            "ЭМГ" => "2.3.",
            "КБМ" => "2.4.",
            "КГМ" => "2.5.",
            "КТМ" => "2.6.",
            "КОА" => "2.7.",
            "УО" => "2.8.",
            "ТШО" => "2.9.",
            "КПО" => "2.10.",
            "НКО" => "2.11.",
            "АГ" => "2.12."
        ),
        'oilCondensateDeliveryWithoutKMG' => array (
            "ОМГ" => "2.1.",
            "ОМГК" => "",
            "ММГ" => "2.2.",
            "ЭМГ" => "2.3.",
            "КГМ" => "2.4.",
            "КОА" => "2.5.",
            "ТШО" => "2.6.",
            "КПО" => "2.7.",
            "НКО" => "2.8.",
            "АГ" => "2.9."
        )
    );
    private $companies = array ('ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА','УО','ТШО','КПО','НКО','АГ');

    private $consolidatedFieldsMapping = array (
        'oilCondensateProductionWithoutKMG' => array(
            'fact' => 'oil_production_fact',
            'plan' => 'plan_oil',
            'opek' => 'plan_oil_opek',
            'condensateFact' => 'condensate_production_fact',
            'condensatePlan' => 'plan_kondensat',
            'condensateOpek' => 'plan_kondensat'
        ),
        'oilCondensateDeliveryWithoutKMG' => array (
            'fact' => 'oil_delivery_fact',
            'plan' => 'plan_oil_dlv',
            'opek' => 'plan_oil_dlv_opek',
            'condensateFact' => 'condensate_delivery_fact',
            'condensatePlan' => 'plan_kondensat_dlv',
            'condensateOpek' => 'plan_kondensat_dlv'
        )
    );

    public function getDataByConsolidatedCategory($factData,$planData,$periodRange,$type,$yearlyPlan,$periodType,$oneDzoSelected)
    {
        if (!is_null($oneDzoSelected)) {
            $this->companies = $oneDzoSelected;
        }
        $summary = array();
        $groupedFact = $factData->groupBy('dzo_name');
        if ($periodRange === 0) {
            $groupedFact = $this->getUpdatedByMissingCompanies($groupedFact);
        }
        foreach($groupedFact as $dzoName => $dzoFact) {
            $filteredPlan = $planData->where('dzo',$dzoName);
            if (count($filteredPlan) === 0) {
                continue;
            }
            if ($dzoName === 'ПКИ') {
                continue;
            }
            $updated = $this->getUpdatedByTroubledCompanies($dzoName,$dzoFact,$filteredPlan,$pkiSumm,$type,$periodType,$yearlyPlan);
            if (count($updated) > 0) {
                $summary = array_merge($summary,$updated);
            }
        }
        $sorted = $this->getSortedById($summary,$type);
        return $sorted;
    }

    private function getUpdatedByMissingCompanies($groupedFact)
    {
        $updatedByMissingCompanies = $groupedFact;
        $presentCompanies = array_keys($updatedByMissingCompanies->toArray());
        $missingCompanies = array_diff($this->companies, $presentCompanies);
        foreach($missingCompanies as $dzoName) {
            $missingData = $this->getMissingCompanyData($dzoName);
            $updatedByMissingCompanies[$dzoName] = array($missingData);
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
             ->first();
    }

    private function getUpdatedByTroubledCompanies($dzo,$dzoFact,$filteredPlan,&$pkiSumm,$type,$periodType,$yearlyPlan)
    {
        $filteredYearlyPlan = $yearlyPlan->where('dzo',$dzo);
        if (!array_key_exists($dzo,$this->consolidatedNumberMapping[$type])) {
            return [];
        }
        $daysInMonth = Carbon::parse($dzoFact[0]['date'])->daysInMonth;
        $summary = array();
        $companySummary = array(
           'id' => $this->consolidatedNumberMapping[$type][$dzo],
           'name' => $dzo,
           'fact' => $dzoFact->sum($this->consolidatedFieldsMapping[$type]['fact']),
           'plan' => $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']),
           'opek' => $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['opek']),
           'condensatePlan' => $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensatePlan']),
           'condensateFact' => $dzoFact->sum($this->consolidatedFieldsMapping[$type]['condensateFact']),
           'condensateOpek' => $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensateOpek']),
           'opec_explanation_reasons' => $this->getAccidentDescription($dzoFact,'opec_explanation_reasons'),
           'impulse_explanation_reasons' => $this->getAccidentDescription($dzoFact,'impulse_explanation_reasons'),
           'shutdown_explanation_reasons' => $this->getAccidentDescription($dzoFact,'shutdown_explanation_reasons'),
           'accident_explanation_reasons' => $this->getAccidentDescription($dzoFact,'accident_explanation_reasons'),
           'restriction_kto_explanation_reasons' => $this->getAccidentDescription($dzoFact,'restriction_kto_explanation_reasons'),
           'gas_restriction_explanation_reasons' => $this->getAccidentDescription($dzoFact,'gas_restriction_explanation_reasons'),
           'other_explanation_reasons' => $this->getAccidentDescription($dzoFact,'other_explanation_reasons'),
        );
        if ($periodType === 'month') {
            $companySummary['monthlyPlan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']) * $daysInMonth;
            $companySummary['plan'] *= Carbon::now()->day - 1;
            $companySummary['opek'] *= Carbon::now()->day - 1;
            $companySummary['condensatePlan'] *= Carbon::now()->day - 1;
            $companySummary['condensateOpek'] *= Carbon::now()->day - 1;
        }
        if ($periodType === 'year') {
            $companySummary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$this->consolidatedFieldsMapping[$type]['plan']);
            $companySummary['plan'] = $this->getCurrentPlanForYear($filteredPlan,'plan',$type);
            $companySummary['opek'] = $this->getCurrentPlanForYear($filteredPlan,'opek',$type);
            $companySummary['condensatePlan'] = $this->getCurrentPlanForYear($filteredPlan,'condensatePlan',$type);
            $companySummary['condensateOpek'] = $this->getCurrentPlanForYear($filteredPlan,'condensateOpek',$type);
        }
        $condensateSummary = $companySummary;

        if ($dzo === 'АГ') {
            $companySummary['fact'] = $companySummary['condensateFact'];
            $companySummary['plan'] = $companySummary['condensatePlan'];
            $companySummary['opek'] = $companySummary['condensateOpek'];
            if ($periodType === 'month') {
                $companySummary['monthlyPlan'] = $companySummary['condensatePlan'] * $daysInMonth;
            }
            if ($periodType === 'year') {
                $companySummary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$this->consolidatedFieldsMapping[$type]['condensatePlan']);
                $companySummary['plan'] = $this->getCurrentPlanForYear($filteredPlan,'condensatePlan',$type);
                $companySummary['opek'] = $this->getCurrentPlanForYear($filteredPlan,'condensateOpek',$type);
            }
        } elseif ($dzo === 'ОМГ') {
            $condensateSummary['id'] = $this->consolidatedNumberMapping[$type]['ОМГК'];
            $condensateSummary['name'] = 'ОМГК';
            $condensateSummary['fact'] = $companySummary['condensateFact'];
            $condensateSummary['plan'] = $companySummary['condensatePlan'];
            $condensateSummary['opek'] = $companySummary['condensateOpek'];
            if ($periodType === 'month') {
                $condensateSummary['monthlyPlan'] = $companySummary['condensatePlan'] * $daysInMonth;
            }
            if ($periodType === 'year') {
                $condensateSummary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$this->consolidatedFieldsMapping[$type]['condensatePlan']);
                $condensateSummary['plan'] = $this->getCurrentPlanForYear($filteredPlan,'condensatePlan',$type);
                $condensateSummary['opek'] = $this->getCurrentPlanForYear($filteredPlan,'condensateOpek',$type);
            }
        }
        if (is_null($companySummary['opek']) || $companySummary['opek'] == 0) {
             $companySummary['opek'] = $companySummary['plan'];
        }
        if (is_null($condensateSummary['opek']) || $condensateSummary['opek'] == 0) {
             $condensateSummary['opek'] = $condensateSummary['plan'];
        }
        if ($dzo === 'ОМГ') {
            array_push($summary,$condensateSummary);
        }
        array_push($summary,$companySummary);
        return $summary;
    }

    private function getAccidentDescription($dzoFact,$fieldName)
    {
        $accidentDescription = '';
        foreach($dzoFact as $item) {
            if (!is_null($item['import_decrease_reason']) && isset($item['import_decrease_reason'][$fieldName])) {
                $accidentDescription .= $item['import_decrease_reason'][$fieldName] . '\n';
            }
        }
        return $accidentDescription;
    }

    private function getYearlyPlanBy($yearlyPlan,$fieldName)
    {
        $summary = 0;
        foreach($yearlyPlan as $monthly) {
            $summary += $monthly[$fieldName] * Carbon::parse($monthly['date'])->daysInMonth;
        }
        return $summary;
    }

    private function getCurrentPlanForYear($filteredPlan,$fieldName,$type)
    {
        $summaryPlan = 0;
        foreach($filteredPlan as $monthlyPlan) {
            if (Carbon::parse($monthlyPlan['date'])->month < Carbon::now()->month) {
                $summaryPlan += $monthlyPlan[$this->consolidatedFieldsMapping[$type][$fieldName]] * Carbon::parse($monthlyPlan['date'])->daysInMonth;
            }
            if (Carbon::parse($monthlyPlan['date'])->month === Carbon::now()->month) {
                $summaryPlan += $monthlyPlan[$this->consolidatedFieldsMapping[$type][$fieldName]] * Carbon::now()->day - 1;
            }
        }
        return $summaryPlan;
    }

    private function getSortedById($data,$type)
    {
        $ordered = array();
        foreach(array_keys($this->consolidatedNumberMapping[$type]) as $value) {
            $key = array_search($value, array_column($data, 'name'));
            if ($data[$key]) {
                array_push($ordered,$data[$key]);
            }
        }
        return $ordered;
    }
    public function getChartData($fact,$plan,$dzoName,$type)
    {
        if (!is_null($dzoName)) {
            $fact = $fact->filter(function($item) {
                return $item->dzo_name === $dzoName;
            });
        }
        $chartData = array();
        $formattedPlan = array();
        foreach($plan as $item) {
            $date = Carbon::parse($item['date'])->format('d/m/Y');
            $formattedPlan[$date][$item['dzo']] = $item->toArray();
        }
        foreach($fact as $item) {
            $date = Carbon::parse($item['date'])->startOfDay()->format('d/m/Y');
            $daySummary = array();
            $formattedDate = Carbon::parse($item['date'])->copy()->firstOfMonth()->startOfDay()->format('d/m/Y');
            $dzoName = $item['dzo_name'];
            $planRecord = $formattedPlan[$formattedDate][$dzoName];
            $daySummary['fact'] = $item[$this->consolidatedFieldsMapping[$type]['fact']];
            $daySummary['plan'] = $planRecord[$this->consolidatedFieldsMapping[$type]['plan']];
            $daySummary['opek'] = $planRecord[$this->consolidatedFieldsMapping[$type]['opek']];
            $daySummary['date'] = $date;
            $daySummary['name'] = $dzoName;
            if ($dzoName === 'ОМГ') {
                $condensateSummary = array();
                $condensateSummary['fact'] = $item[$this->consolidatedFieldsMapping[$type]['condensateFact']];
                $condensateSummary['plan'] = $planRecord[$this->consolidatedFieldsMapping[$type]['condensatePlan']];
                $condensateSummary['opek'] = $planRecord[$this->consolidatedFieldsMapping[$type]['condensateOpek']];
                $condensateSummary['date'] = $date;
                $condensateSummary['name'] = 'ОМГК';
                array_push($chartData,$condensateSummary);
            }
            if ($dzoName === 'АГ') {
                $daySummary['fact'] = $item[$this->consolidatedFieldsMapping[$type]['condensateFact']];
                $daySummary['plan'] = $planRecord[$this->consolidatedFieldsMapping[$type]['condensatePlan']];
                $daySummary['opek'] = $planRecord[$this->consolidatedFieldsMapping[$type]['condensateOpek']];
            }
            if ($daySummary['opek'] == 0) {
                $daySummary['opek'] = $daySummary['plan'];
            }
            array_push($chartData,$daySummary);
        }
        return $chartData;
    }
}
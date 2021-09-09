<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;

class OilCondensateConsolidated {
    private $consolidatedNumberMapping = array (
        'oilCondensateProduction' => array (
            'ОМГ' => '1.1.',
            'ОМГК' => '',
            'ММГ' => '1.2.',
            'ЭМГ' => '1.3.',
            'КБМ' => '1.4.',
            'КГМ' => '1.5.',
            'КТМ' => '1.6.',
            'КОА' => '1.7.',
            'УО' => '1.8.',
            'ТШО' => '1.9.',
            'НКО' => '1.10.',
            'КПО' => '1.11.',
            'ПКИ' => '1.12.',
            'ПККР' => '',
            'КГМКМГ' => '',
            'ТП' => '',
            'АГ' => '1.13.',
        ),
        'oilCondensateDelivery' => array (
            "ОМГ" => "1.1.",
            "ОМГК" => "",
            "ММГ" => "1.2.",
            "ЭМГ" => "1.3.",
            "КБМ" => "1.4.",
            "КГМ" => "1.5.",
            "КТМ" => "1.6.",
            "КОА" => "1.7.",
            "ТШО" => "1.8.",
            "НКО" => "1.9.",
            "ПКИ" => "1.10.",
            "КГМКМГ" => "",
            "ПККР" => "",
            "ТП" => "",
            "АГ" => "1.11."
        ),
    );
    private $companies = array ('ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА','УО','ТШО','НКО','КПО','ПКИ','ПКК','ТП','АГ');
    private $consolidatedFieldsMapping = array (
        'oilCondensateProduction' => array(
            'fact' => 'oil_production_fact',
            'plan' => 'plan_oil',
            'opek' => 'plan_oil_opek',
            'condensateFact' => 'condensate_production_fact',
            'condensatePlan' => 'plan_kondensat',
            'condensateOpek' => 'plan_kondensat'
        ),
        'oilCondensateDelivery' => array (
            'fact' => 'oil_delivery_fact',
            'plan' => 'plan_oil_dlv',
            'opek' => 'plan_oil_dlv_opek',
            'condensateFact' => 'condensate_delivery_fact',
            'condensatePlan' => 'plan_kondensat_dlv',
            'condensateOpek' => 'plan_kondensat_dlv'
        ),
        'gasProduction' => array(
            'naturalFact' => 'natural_gas_production_fact',
            'associatedFact' => 'associated_gas_production_fact',
            'naruralPlan' => 'plan_prirod_gas',
            'associatedPlan' => 'plan_poput_gas'
        ),
    );
    private $dzoMultiplier = array (
        'ПКК' => 0.33,
        'КГМ' => 0.5 * 0.33,
        'ТП' => 0.5 * 0.33,
        'НКО' => ((1 - 0.019) * 241 / 1428) / 2
    );

    private $dzoTableMultiplier = array (
        'ПКК' => 0.33,
        'ПККР' => 0.33,
        'КГМ' => 0.5 * 0.33,
        'ТП' => 0.5 * 0.33,
        'НКО' => ((1 - 0.019) * 241 / 1428) / 2,
        'ММГ' => 0.5,
        'КБМ' => 0.5,
        'КОА' => 0.5,
        'КГМ' => 0.5,
        'ТШО' => 0.2,
        'КПО' => 0.1
    );

    private $companyTemplate = array(
        'id' => '',
        'name' => '',
        'fact' => 0,
        'plan' => 0,
        'opek' => 0,
        'condensatePlan' => 0,
        'condensateFact' => 0,
        'condensateOpek' => 0,
        'opec_explanation_reasons' => '',
        'impulse_explanation_reasons' => '',
        'shutdown_explanation_reasons' => '',
        'accident_explanation_reasons' => '',
        'restriction_kto_explanation_reasons' => '',
        'gas_restriction_explanation_reasons' => '',
        'other_explanation_reasons' => '',
   );

    public function getDataByConsolidatedCategory($factData,$planData,$periodRange,$type,$yearlyPlan,$periodType,$oneDzoSelected)
    {
        if (!is_null($oneDzoSelected)) {
            $this->companies = array();
            $this->companies[] = $oneDzoSelected;
        }
        $summary = array();
        $factData = $factData->filter(function($item) {
            return in_array($item->dzo_name,$this->companies);
        });

        $groupedFact = $factData->groupBy('dzo_name');
        $pkiSumm = array (
            'fact' => 0,
            'plan' => 0,
            'opek' => 0,
            'monthlyPlan' => 0,
            'yearlyPlan' => 0
        );
        if ($periodRange === 0 && is_null($oneDzoSelected)) {
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
        if (is_null($oneDzoSelected)) {
            array_push($summary,array(
                  'id' => $this->consolidatedNumberMapping[$type]['ПКИ'],
                  'name' => 'ПКИ',
                  'fact' => $pkiSumm['fact'],
                  'plan' => $pkiSumm['plan'],
                  'opek' => $pkiSumm['opek'],
                  'monthlyPlan' => $pkiSumm['monthlyPlan'],
                  'yearlyPlan' => $pkiSumm['yearlyPlan']
            ));
            $sorted = $this->getSortedById($summary,$type);
            return $sorted;
        }
        return $summary;
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

    private function getUpdatedByTroubledCompanies($dzo,$dzoFact,$filteredPlan,&$pkiSumm,$type,$periodType,$yearlyPlan)
    {
        $filteredYearlyPlan = $yearlyPlan->where('dzo',$dzo);
        if ($dzo === 'ПКК') {
            $dzo = 'ПККР';
        }

        if (!array_key_exists($dzo,$this->consolidatedNumberMapping[$type])) {
            return [];
        }
        $daysInMonth = Carbon::parse($dzoFact[0]['date'])->daysInMonth;
        $summary = array();
        $companySummary = $this->companyTemplate;
        $companySummary['id'] = $this->consolidatedNumberMapping[$type][$dzo];
        $companySummary['name'] = $dzo;
        $companySummary['fact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['fact']);
        $companySummary['plan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']);
        $companySummary['opek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['opek']);
        $companySummary['condensatePlan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensatePlan']);
        $companySummary['condensateFact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['condensateFact']);
        $companySummary['condensateOpek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensateOpek']);

        if ($periodType === 'day') {
            $companySummary['opec_explanation_reasons'] = $this->getAccidentDescription($dzoFact,'opec_explanation_reasons');
            $companySummary['impulse_explanation_reasons'] = $this->getAccidentDescription($dzoFact,'impulse_explanation_reasons');
            $companySummary['shutdown_explanation_reasons'] = $this->getAccidentDescription($dzoFact,'shutdown_explanation_reasons');
            $companySummary['accident_explanation_reasons'] = $this->getAccidentDescription($dzoFact,'accident_explanation_reasons');
            $companySummary['restriction_kto_explanation_reasons'] = $this->getAccidentDescription($dzoFact,'restriction_kto_explanation_reasons');
            $companySummary['gas_restriction_explanation_reasons'] = $this->getAccidentDescription($dzoFact,'gas_restriction_explanation_reasons');
            $companySummary['other_explanation_reasons'] = $this->getAccidentDescription($dzoFact,'other_explanation_reasons');
        }
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
        } elseif ($dzo === 'КГМ') {
            $condensateSummary = $companySummary;
            $condensateSummary['id'] = $this->consolidatedNumberMapping[$type]['КГМКМГ'];
            $condensateSummary['name'] = 'КГМКМГ';
            $condensateSummary['fact'] *= $this->dzoTableMultiplier[$dzo];
            $condensateSummary['plan'] *= $this->dzoTableMultiplier[$dzo];
            if ($periodType === 'month') {
                $condensateSummary['monthlyPlan'] *= $this->dzoTableMultiplier[$dzo];
            }
            if ($periodType === 'year') {
                $condensateSummary['yearlyPlan'] *= $this->dzoTableMultiplier[$dzo];
            }
            $condensateSummary['opek'] *= $this->dzoTableMultiplier[$dzo];
            $pkiSumm['fact'] += $condensateSummary['fact'];
            $pkiSumm['plan'] += $condensateSummary['plan'];
            $pkiSumm['opek'] += $condensateSummary['opek'];
            if ($periodType === 'month') {
                $pkiSumm['monthlyPlan'] += $condensateSummary['monthlyPlan'];
            }
            if ($periodType === 'year') {
                $pkiSumm['yearlyPlan'] += $condensateSummary['yearlyPlan'];
            }

        } elseif (in_array($dzo, array('ПККР','ТП'))) {
            $companySummary['fact'] *= $this->dzoTableMultiplier[$dzo];
            $companySummary['plan'] *= $this->dzoTableMultiplier[$dzo];
            $companySummary['opek'] *= $this->dzoTableMultiplier[$dzo];
            if ($periodType === 'month') {
                $companySummary['monthlyPlan'] *= $this->dzoTableMultiplier[$dzo];
            }
            if ($periodType === 'year') {
                $companySummary['yearlyPlan'] *= $this->dzoTableMultiplier[$dzo];
            }
            $pkiSumm['fact'] += $companySummary['fact'];
            $pkiSumm['plan'] += $companySummary['plan'];
            $pkiSumm['opek'] += $companySummary['opek'];
            if ($periodType === 'month') {
                $pkiSumm['monthlyPlan'] += $companySummary['monthlyPlan'];
            }
            if ($periodType === 'year') {
                $pkiSumm['yearlyPlan'] += $companySummary['yearlyPlan'];
            }
        }
        if (in_array($dzo, array('ММГ','КБМ','КОА','КГМ','ТШО','КПО','НКО'))) {
            $companySummary['fact'] *= $this->dzoTableMultiplier[$dzo];
            $companySummary['plan'] *= $this->dzoTableMultiplier[$dzo];
            $companySummary['opek'] *= $this->dzoTableMultiplier[$dzo];
            if ($periodType === 'month') {
                $companySummary['monthlyPlan'] *= $this->dzoTableMultiplier[$dzo];
            }
            if ($periodType === 'year') {
                $companySummary['yearlyPlan'] *= $this->dzoTableMultiplier[$dzo];
            }
        }
        if (is_null($companySummary['opek']) || $companySummary['opek'] == 0) {
             $companySummary['opek'] = $companySummary['plan'];
        }
        if (is_null($condensateSummary['opek']) || $condensateSummary['opek'] == 0) {
              $condensateSummary['opek'] = $condensateSummary['plan'];
        }
        if (in_array($dzo, array('КГМ','ОМГ'))) {
            array_push($summary,$condensateSummary);
        }
        array_push($summary,$companySummary);
        return $summary;
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

    private function getAccidentDescription($dzoFact,$fieldName)
    {
        foreach($dzoFact as $item) {
            if (!is_null($item['importDecreaseReason']) && isset($item['importDecreaseReason'][$fieldName])) {
                return $item['importDecreaseReason'][$fieldName];
            }
        }
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
    public function getChartData($fact,$plan,$dzoName,$type)
    {
        if (!is_null($dzoName)) {
            $fact = $fact->filter(function($item) use($dzoName) {
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
            if (array_key_exists($dzoName,$this->dzoMultiplier)) {
                $daySummary['fact'] *= $this->dzoMultiplier[$dzoName];
                $daySummary['plan'] *= $this->dzoMultiplier[$dzoName];
                $daySummary['opek'] *= $this->dzoMultiplier[$dzoName];
            }
            array_push($chartData,$daySummary);
        }
        return $chartData;
    }
}
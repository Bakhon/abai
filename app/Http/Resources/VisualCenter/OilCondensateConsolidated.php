<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Http\Resources\VisualCenter\Dzo;
use Carbon\Carbon;

class OilCondensateConsolidated extends Dzo {
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

    private $decreaseReasonFields = array (
        'opec_explanation_reasons',
        'impulse_explanation_reasons',
        'shutdown_explanation_reasons',
        'accident_explanation_reasons',
        'restriction_kto_explanation_reasons',
        'gas_restriction_explanation_reasons',
        'other_explanation_reasons'
    );

    public function getDataByConsolidatedCategory($factData,$planData,$periodRange,$type,$yearlyPlan,$periodType,$oneDzoSelected)
    {
        if (!is_null($oneDzoSelected)) {
            $this->companies = array();
            $this->companies[] = $oneDzoSelected;
        }

        $factData = $factData->filter(function($item) {
            return in_array($item->dzo_name,$this->companies);
        });

        $pkiSumm = array (
            'fact' => 0,
            'plan' => 0,
            'opek' => 0,
            'monthlyPlan' => 0,
            'yearlyPlan' => 0
        );
        $groupedFact = $this->getGroupedFact($factData);
        if ($periodRange === 0 && is_null($oneDzoSelected)) {
            $groupedFact = $this->getUpdatedByMissingCompanies($groupedFact);
        }

        $summary = $this->getSummary($groupedFact,$planData,$type,$periodType,$yearlyPlan,$pkiSumm);
        if (!is_null($oneDzoSelected)) {
            return $summary;
        }
        array_push($summary,array(
              'id' => $this->consolidatedNumberMapping[$type]['ПКИ'],
              'name' => 'ПКИ',
              'fact' => $pkiSumm['fact'],
              'plan' => $pkiSumm['plan'],
              'opek' => $pkiSumm['opek'],
              'monthlyPlan' => $pkiSumm['monthlyPlan'],
              'yearlyPlan' => $pkiSumm['yearlyPlan'],
              'decreaseReasonExplanations' => []
        ));
        $sorted = $this->getSortedById($summary,$type);
        return $sorted;

    }

    private function getGroupedFact($factData)
    {
        return $factData->groupBy('dzo_name');
    }

    private function getSummary($groupedFact,$planData,$type,$periodType,$yearlyPlan,&$pkiSumm)
    {
        $summary = array();
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

    private function getUpdatedByTroubledCompanies($dzoName,$dzoFact,$filteredPlan,&$pkiSumm,$type,$periodType,$yearlyPlan)
    {
        $filteredYearlyPlan = $yearlyPlan->where('dzo',$dzoName);
        if ($dzoName === 'ПКК') {
            $dzoName = 'ПККР';
        }

        if (!array_key_exists($dzoName,$this->consolidatedNumberMapping[$type])) {
            return [];
        }
        return $this->getSummaryByOilCondensate($dzoFact,$dzoName,$filteredPlan,$pkiSumm,$type,$periodType,$filteredYearlyPlan);
    }

    protected function getUpdatedForMonthPeriod($companySummary,$filteredPlan,$type,$daysInMonth)
    {
        $summary = $companySummary;
        $summary['monthlyPlan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']) * $daysInMonth;
        $summary['plan'] *= Carbon::now()->day - 1;
        $summary['opek'] *= Carbon::now()->day - 1;
        $summary['condensatePlan'] *= Carbon::now()->day - 1;
        $summary['condensateOpek'] *= Carbon::now()->day - 1;
        return $summary;
    }

    protected function getUpdatedForYearPeriod($companySummary,$filteredPlan,$type,$daysInMonth,$filteredYearlyPlan)
    {
        $summary = $companySummary;
        $summary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$this->consolidatedFieldsMapping[$type]['plan']);
        $summary['plan'] = $this->getCurrentPlanForYear($filteredPlan,'plan',$type);
        $summary['opek'] = $this->getCurrentPlanForYear($filteredPlan,'opek',$type);
        $summary['condensatePlan'] = $this->getCurrentPlanForYear($filteredPlan,'condensatePlan',$type);
        $summary['condensateOpek'] = $this->getCurrentPlanForYear($filteredPlan,'condensateOpek',$type);
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

    protected function getAccidentDescription($dzoFact)
    {
        $accidents = array();
        $dzoFactData = $dzoFact[0];
        foreach($this->decreaseReasonFields as $fieldName) {
            if (!is_null($dzoFactData['importDecreaseReason']) && isset($dzoFactData['importDecreaseReason'][$fieldName])) {
               array_push($accidents,$dzoFactData['importDecreaseReason'][$fieldName]);
            }
        }
        return $accidents;
    }

    public function getChartData($fact,$plan,$dzoName,$type)
    {
        if (!is_null($dzoName)) {
            $fact = $fact->filter(function($item) use($dzoName) {
                return $item->dzo_name === $dzoName;
            });
        }

        $formattedPlan = array();
        foreach($plan as $item) {
            $date = Carbon::parse($item['date'])->format('d/m/Y');
            $formattedPlan[$date][$item['dzo']] = $item->toArray();
        }

        return $this->getChartDataByOilCondensate($formattedPlan,$fact,$type);
    }
}
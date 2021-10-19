<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;

class GasProduction {
    private $companies = array('ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА','УО');
    private $fieldsMapping = array (
        'naturalGasProduction' => array(
            'fact' => 'natural_gas_production_fact',
            'plan' => 'plan_prirod_gas'
        ),
        'associatedGasProduction' => array(
            'fact' => 'associated_gas_production_fact',
            'plan' => 'plan_poput_gas'
        ),
        'associatedGasFlaring' => array(
            'fact' => 'associated_gas_flaring_fact',
            'plan' => 'plan_poput_gas_burn'
        ),
        'naturalGasDelivery' => array(
            'fact' => 'natural_gas_delivery_fact',
            'plan' => 'plan_prirod_gas_dlv'
        ),
        'expensesForOwnNaturalGas' => array(
            'fact' => 'natural_gas_expenses_for_own_fact',
            'plan' => 'plan_prirod_gas_raskhod'
        ),
        'associatedGasDelivery' => array(
            'fact' => 'associated_gas_delivery_fact',
            'plan' => 'plan_poput_gas_dlv'
        ),
        'expensesForOwnAssociatedGas' => array(
            'fact' => 'associated_gas_expenses_for_own_fact',
            'plan' => 'plan_poput_gas_raskhod'
        ),
        'processingAssociatedGas' => array(
            'fact' => 'associated_gas_processing_fact',
            'plan' => 'plan_poput_gas_pererabotka'
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
            $summaryByCategories[$subcategory] = $this->getDataBySubCategory($groupedFact,$planData,$periodType,$yearlyPlan,$fields,$periodRange);
        }
        $summaryByCategories['gasProduction'] = $this->getSummary($summaryByCategories['naturalGasProduction'],$summaryByCategories['associatedGasProduction']);
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

    private function getDataBySubCategory($groupedFact,$planData,$periodType,$yearlyPlan,$fields,$periodRange)
    {
        $summary = array();
        foreach($groupedFact as $dzoName => $dzoFact) {
            $filteredPlan = $planData->where('dzo',$dzoName);
            if (count($filteredPlan) === 0) {
                continue;
            }
            $updated = $this->getData($dzoName,$dzoFact,$filteredPlan,$periodType,$yearlyPlan,$fields);
            if (count($updated) > 0) {
                $summary = array_merge($summary,$updated);
            }
        }
        return $this->getSortedByPlan($summary);
    }

    private function getData($dzo,$dzoFact,$filteredPlan,$periodType,$yearlyPlan,$categoryFields)
    {
        $filteredYearlyPlan = $yearlyPlan->where('dzo',$dzo);
        $daysInMonth = Carbon::parse($dzoFact[0]['date'])->daysInMonth;
        $summary = array();
        $companySummary = array(
           'id' => '1.',
           'name' => $dzo,
           'fact' => $dzoFact->sum($categoryFields['fact']),
           'plan' => $filteredPlan->sum($categoryFields['plan']),
           'decreaseReasonExplanations' => []
        );
        if ($periodType === 'day') {
            $companySummary['decreaseReasonExplanations'] = $this->getAccidentDescription($dzoFact);
        }
        if ($periodType === 'month') {
            $companySummary['monthlyPlan'] = $filteredPlan->sum($categoryFields['plan']) * $daysInMonth;
        }
        if ($periodType === 'year') {
            $companySummary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$categoryFields['plan']);
            $companySummary['plan'] = $this->getCurrentPlanForYear($filteredPlan,$categoryFields['plan']);
        }
        if ($companySummary['plan'] + $companySummary['fact'] <= 0) {
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
            if (!is_null($dzoFactData['importDecreaseReason']) && isset($dzoFactData['importDecreaseReason'][$fieldName])) {
               array_push($accidents,$dzoFactData['importDecreaseReason'][$fieldName]);
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
        $summary = 0;
        foreach($filteredPlan as $plan) {
            $summary += $plan[$fieldName] * Carbon::parse($plan['date'])->daysInMonth;
        }
        return $summary;
    }

    private function getSortedByPlan($data)
    {
        $sorted = array_column($data, 'plan');
        array_multisort($sorted, SORT_DESC, $data);
        return $data;
    }

    private function getSummary($naturalGas,$associatedGas)
    {
        $summaryGas = array();
        foreach($this->companies as $dzoName) {
            $filteredAssociatedGas = array_filter($associatedGas, function($item) use($dzoName) {
                return $dzoName === $item['name'];
            });
            $filteredNaturalGas = array_filter($naturalGas, function($item) use($dzoName) {
                return $dzoName === $item['name'];
            });
            $summary = [];
            foreach($filteredAssociatedGas as $value) {
                $summary = $value;
                $summary['fact'] += array_sum(array_column($filteredNaturalGas,'fact'));
                $summary['plan'] += array_sum(array_column($filteredNaturalGas,'plan'));
            }
            array_push($summaryGas,$summary);
        }
        return $this->getSortedByPlan($summaryGas);
    }

    public function getChartData($fact,$plan,$dzoName,$type,$periodRange,$periodType)
    {
        if (!is_null($dzoName)) {
            $this->companies = array();
            $this->companies[] = $dzoName;
        }
        $fact = $fact->filter(function($item) {
            return in_array($item->dzo_name,$this->companies);
        });
        $chartData = array();
        $formattedPlan = array();
        foreach($plan as $item) {
            $date = Carbon::parse($item['date'])->format('d/m/Y');
            $formattedPlan[$date][$item['dzo']] = $item->toArray();
        }
        if ($type === 'gasProduction') {
            $factField = $this->fieldsMapping['naturalGasProduction']['fact'];
            $planField = 'plan_gas';
        } else {
            $factField = $this->fieldsMapping[$type]['fact'];
            $planField = $this->fieldsMapping[$type]['plan'];
        }
        foreach($fact as $item) {
            $date = Carbon::parse($item['date'])->startOfDay()->format('d/m/Y');
            $daySummary = array();
            $formattedDate = Carbon::parse($item['date'])->copy()->firstOfMonth()->startOfDay()->format('d/m/Y');
            $dzoName = $item['dzo_name'];
            $planRecord = $formattedPlan[$formattedDate][$dzoName];
            $daySummary['fact'] = $item[$factField];
            if ($periodType === 'year') {
                $daySummary['plan'] = $planRecord[$planField];
            } else {
                $daySummary['plan'] = $planRecord[$planField] / $periodRange;
            }
            $daySummary['date'] = $date;
            $daySummary['name'] = $dzoName;
            if ($type === 'gasProduction') {
               $daySummary['fact'] +=  $item[$this->fieldsMapping['associatedGasProduction']['fact']];
            }
            array_push($chartData,$daySummary);
        }
        return $chartData;
    }

}
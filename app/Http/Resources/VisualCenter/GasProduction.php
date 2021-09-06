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
    );

    public function getDataByCategory($factData,$planData,$periodRange,$yearlyPlan,$periodType,$oneDzoSelected)
    {
        if (!is_null($oneDzoSelected)) {
            $this->companies = $oneDzoSelected;
        }
        $factData = $factData->filter(function($item) {
            return in_array($item->dzo_name,$this->companies);
        });
        $groupedFact = $factData->groupBy('dzo_name');
        if ($periodRange === 0) {
            $groupedFact = $this->getUpdatedByMissingCompanies($groupedFact);
        }
        $summaryByCategories = array();
        foreach($this->fieldsMapping as $subcategory => $fields) {
            $summaryByCategories[$subcategory] = $this->getDataBySubCategory($groupedFact,$planData,$periodType,$yearlyPlan,$fields);
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
                $sorted = $this->getSortedById($updated);
                $summary = array_merge($summary,$updated);
            }
        }
        return $summary;
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
           'opec_explanation_reasons' => $this->getAccidentDescription($dzoFact,'opec_explanation_reasons'),
           'impulse_explanation_reasons' => $this->getAccidentDescription($dzoFact,'impulse_explanation_reasons'),
           'shutdown_explanation_reasons' => $this->getAccidentDescription($dzoFact,'shutdown_explanation_reasons'),
           'accident_explanation_reasons' => $this->getAccidentDescription($dzoFact,'accident_explanation_reasons'),
           'restriction_kto_explanation_reasons' => $this->getAccidentDescription($dzoFact,'restriction_kto_explanation_reasons'),
           'gas_restriction_explanation_reasons' => $this->getAccidentDescription($dzoFact,'gas_restriction_explanation_reasons'),
           'other_explanation_reasons' => $this->getAccidentDescription($dzoFact,'other_explanation_reasons'),
        );
        if ($periodType === 'month') {
            $companySummary['monthlyPlan'] = array_column($filteredPlan,$categoryFields['plan'])[0] * $daysInMonth;
            $companySummary['plan'] *= Carbon::now()->day - 1;
        }
        if ($periodType === 'year') {
            $companySummary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$categoryFields['plan']);
            $companySummary['plan'] = $this->getCurrentPlanForYear($filteredPlan,$categoryFields['plan']);
        }
        if ($companySummary['plan'] + $companySummary['fact'] === 0) {
            return $summary;
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
        foreach(array_keys($this->companies) as $value) {
            $key = array_search($value, array_column($data, 'name'));
            if ($data[$key]) {
                array_push($ordered,$data[$key]);
            }
        }
        return $ordered;
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
            foreach($filteredAssociatedGas as $value) {
                $summary = $value;
                $summary['fact'] += array_sum(array_column($filteredNaturalGas,'fact'));
                $summary['plan'] += array_sum(array_column($filteredNaturalGas,'plan'));
            }
            array_push($summaryGas,$summary);
        }
        return $summaryGas;
    }

}
<?php

namespace App\Traits\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;

trait OilCondensateConsolidated {
    private $consolidatedNumberMapping = array (
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
    );
    private $companies = array ('ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА','УО','ТШО','НКО','КПО','ПКИ','ПКК','ТП','АГ');
    private $consolidatedFieldsMapping = array (
        'oilProduction' => array(
            'fact' => 'oil_production_fact',
            'plan' => 'plan_oil',
            'opek' => 'plan_oil_opek'
        ),
        'oilDelivery' => array (
            'fact' => 'oil_delivery_fact',
            'plan' => 'plan_oil_dlv',
            'opek' => 'plan_oil_dlv_opek'
        ),
        'condensateProduction' => array (
            'fact' => 'condensate_production_fact',
            'plan' => 'plan_kondensat',
            'opek' => 'plan_kondensat'
        ),
        'condensateDelivery' => array (
            'fact' => 'condensate_delivery_fact',
            'plan' => 'plan_kondensat_dlv',
            'opek' => 'plan_kondensat_dlv'
        ),
        'gasProduction' => array(
            'naturalFact' => 'natural_gas_production_fact',
            'associatedFact' => 'associated_gas_production_fact',
            'naruralPlan' => 'plan_prirod_gas',
            'associatedPlan' => 'plan_poput_gas'
        ),
    );

    private function getDataByConsolidatedCategory($factData,$planData)
    {
        $summary = array();
        $groupedFact = $factData->groupBy('dzo_name');
        $pkiSumm = array (
            'oilProductionFact' => 0,
            'oilProductionPlan' => 0,
            'productionOpek' => 0,
            'oilDeliveryFact' => 0,
            'oilDeliveryPlan' => 0,
            'deliveryOpek' => 0
        );
        if ($this->periodRange === 0) {
            $groupedFact = $this->getUpdatedByMissingCompanies($groupedFact);
        }
        foreach($groupedFact as $dzoName => $dzoFact) {
            $factDates = array();
            foreach($dzoFact as $dayFact) {
                array_push($factDates,Carbon::parse($dayFact->date)->copy()->firstOfMonth()->format('d.m.Y'));
            }
            if (!is_array($dzoFact)) {
                $dzoFact = $dzoFact->toArray();
            }
            $filteredPlan = $planData->filter(function($item) use($dzoName,$factDates) {
                return in_array($item->dates,$factDates) && $item->dzo === $dzoName;
            })->toArray();
            $dzo = $dzoName;
            if ($dzo === 'ПКК') {
                $dzo = 'ПККР';
            } elseif ($dzo === 'ПКИ') {
                continue;
            }
            $summary = array_merge($summary,$this->getUpdatedByTroubledCompanies($dzo,$dzoFact,$filteredPlan,$pkiSumm));
        }
        array_push($summary,array(
              'id' => $this->consolidatedNumberMapping['ПКИ'],
              'name' => 'ПКИ',
              'oilProductionFact' => $pkiSumm['oilProductionFact'],
              'oilProductionPlan' => $pkiSumm['oilProductionPlan'],
              'oilDeliveryFact' => $pkiSumm['oilDeliveryFact'],
              'oilDeliveryPlan' => $pkiSumm['oilDeliveryPlan'],
              'productionOpek' => $pkiSumm['productionOpek'],
              'deliveryOpek' => $pkiSumm['deliveryOpek'],
        ));
        $sorted = $this->getSortedById($summary);
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
             ->select($this->factFields)
             ->addSelect('date')
             ->where('dzo_name',$dzoName)
             ->whereNull('is_corrected')
             ->with('importDecreaseReason')
             ->latest('date')
             ->first();
    }

    private function getUpdatedByTroubledCompanies($dzo,$dzoFact,$filteredPlan,&$pkiSumm)
    {
        $summary = array();
        $productionPlan = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['oilProduction']['plan']));
        $deliveryPlan = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['oilDelivery']['plan']));
        $productionOpek = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['oilProduction']['opek']));
        $deliveryOpek = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['oilDelivery']['opek']));
        if (is_null($productionOpek)) {
            $productionOpek = $productionPlan;
        }
        if (is_null($deliveryOpek)) {
            $deliveryOpek = $deliveryPlan;
        }
        $companySummary = array(
           'id' => $this->consolidatedNumberMapping[$dzo],
           'name' => $dzo,
           'oilProductionFact' => array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['oilProduction']['fact'])),
           'oilDeliveryFact' => array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['oilDelivery']['fact'])),
           'oilProductionPlan' => $productionPlan,
           'oilDeliveryPlan' => $deliveryPlan,
           'productionOpek' => $productionOpek,
           'deliveryOpek' => $deliveryOpek,
           'opec_explanation_reasons' => $this->getAccidentDescription($dzoFact,'opec_explanation_reasons'),
           'impulse_explanation_reasons' => $this->getAccidentDescription($dzoFact,'impulse_explanation_reasons'),
           'shutdown_explanation_reasons' => $this->getAccidentDescription($dzoFact,'shutdown_explanation_reasons'),
           'accident_explanation_reasons' => $this->getAccidentDescription($dzoFact,'accident_explanation_reasons'),
           'restriction_kto_explanation_reasons' => $this->getAccidentDescription($dzoFact,'restriction_kto_explanation_reasons'),
           'gas_restriction_explanation_reasons' => $this->getAccidentDescription($dzoFact,'gas_restriction_explanation_reasons'),
           'other_explanation_reasons' => $this->getAccidentDescription($dzoFact,'other_explanation_reasons'),
        );
        if ($dzo === 'АГ') {
            $companySummary['oilProductionFact'] = array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['condensateProduction']['fact']));
            $companySummary['oilProductionPlan'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateProduction']['plan']));
            $companySummary['productionOpek'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateProduction']['opek']));
            $companySummary['oilDeliveryFact'] = array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['condensateDelivery']['fact']));
            $companySummary['oilDeliveryPlan'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateDelivery']['plan']));
            $companySummary['deliveryOpek'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateDelivery']['opek']));
        } elseif ($dzo === 'ОМГ') {
            $condensateSummary = $companySummary;
            $condensateSummary['id'] = $this->consolidatedNumberMapping['ОМГК'];
            $condensateSummary['name'] = 'ОМГК';
            $condensateSummary['oilProductionFact'] = array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['condensateProduction']['fact']));
            $condensateSummary['oilProductionPlan'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateProduction']['plan']));
            $condensateSummary['productionOpek'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateProduction']['opek']));
            $condensateSummary['oilDeliveryFact'] = array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['condensateDelivery']['fact']));
            $condensateSummary['oilDeliveryPlan'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateDelivery']['fact']));
            $condensateSummary['deliveryOpek'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateDelivery']['opek']));
            array_push($summary,$condensateSummary);
        } elseif ($dzo === 'КГМ') {
            $condensateSummary = $companySummary;
            $condensateSummary['id'] = $this->consolidatedNumberMapping['КГМКМГ'];
            $condensateSummary['name'] = 'КГМКМГ';
            $condensateSummary['oilProductionFact'] *= 0.5 * 0.33;
            $condensateSummary['oilDeliveryFact'] *= 0.5 * 0.33;
            $condensateSummary['oilProductionPlan'] *= 0.5 * 0.33;
            $condensateSummary['oilDeliveryPlan'] *= 0.5 * 0.33;
            $condensateSummary['productionOpek'] *= 0.5 * 0.33;
            $condensateSummary['deliveryOpek'] *= 0.5 * 0.33;
            $pkiSumm['oilProductionFact'] += $condensateSummary['oilProductionFact'];
            $pkiSumm['oilProductionPlan'] += $condensateSummary['oilProductionPlan'];
            $pkiSumm['oilDeliveryFact'] += $condensateSummary['oilDeliveryFact'];
            $pkiSumm['oilDeliveryPlan'] += $condensateSummary['oilDeliveryPlan'];
            $pkiSumm['productionOpek'] += $condensateSummary['productionOpek'];
            $pkiSumm['deliveryOpek'] += $condensateSummary['deliveryOpek'];
            array_push($summary,$condensateSummary);
        } elseif ($dzo === 'ПККР') {
             $companySummary['oilProductionFact'] *= 0.33;
             $companySummary['oilProductionPlan'] *= 0.33;
             $companySummary['oilDeliveryFact'] *= 0.33;
             $companySummary['oilDeliveryPlan'] *= 0.33;
             $companySummary['productionOpek'] *= 0.33;
             $companySummary['deliveryOpek'] *= 0.33;
             $pkiSumm['oilProductionFact'] += $companySummary['oilProductionFact'];
             $pkiSumm['oilProductionPlan'] += $companySummary['oilProductionPlan'];
             $pkiSumm['oilDeliveryFact'] += $companySummary['oilDeliveryFact'];
             $pkiSumm['oilDeliveryPlan'] += $companySummary['oilDeliveryPlan'];
             $pkiSumm['productionOpek'] += $companySummary['productionOpek'];
             $pkiSumm['deliveryOpek'] += $companySummary['deliveryOpek'];
         } elseif ($dzo === 'ТП') {
             $companySummary['oilProductionFact'] *= 0.5 * 0.33;
             $companySummary['oilProductionPlan'] *= 0.5 * 0.33;
             $companySummary['oilDeliveryFact'] *= 0.5 * 0.33;
             $companySummary['oilDeliveryPlan'] *= 0.5 * 0.33;
             $companySummary['productionOpek'] *= 0.5 * 0.33;
             $companySummary['deliveryOpek'] *= 0.5 * 0.33;
             $pkiSumm['oilProductionFact'] += $companySummary['oilProductionFact'];
             $pkiSumm['oilProductionPlan'] += $companySummary['oilProductionPlan'];
             $pkiSumm['oilDeliveryFact'] += $companySummary['oilDeliveryFact'];
             $pkiSumm['oilDeliveryPlan'] += $companySummary['oilDeliveryPlan'];
             $pkiSumm['productionOpek'] += $companySummary['productionOpek'];
             $pkiSumm['deliveryOpek'] += $companySummary['deliveryOpek'];
         }
         if (in_array($dzo, array('ММГ','КБМ','КОА','КГМ'))) {
            $companySummary['oilProductionFact'] *= 0.5;
            $companySummary['oilProductionPlan'] *= 0.5;
            $companySummary['oilDeliveryFact'] *= 0.5;
            $companySummary['oilDeliveryPlan'] *= 0.5;
            $companySummary['productionOpek'] *= 0.5;
            $companySummary['deliveryOpek'] *= 0.5;
         }
         if ($dzo === 'ТШО') {
            $companySummary['oilProductionFact'] *= 0.2;
            $companySummary['oilProductionPlan'] *= 0.2;
            $companySummary['oilDeliveryFact'] *= 0.2;
            $companySummary['oilDeliveryPlan'] *= 0.2;
            $companySummary['productionOpek'] *= 0.2;
            $companySummary['deliveryOpek'] *= 0.2;
         }
         if ($dzo === 'КПО') {
            $companySummary['oilProductionFact'] *= 0.1;
            $companySummary['oilProductionPlan'] *= 0.1;
            $companySummary['oilDeliveryFact'] *= 0.1;
            $companySummary['oilDeliveryPlan'] *= 0.1;
            $companySummary['productionOpek'] *= 0.1;
            $companySummary['deliveryOpek'] *= 0.1;
         }
         if ($dzo === 'НКО') {
            $companySummary['oilProductionFact'] = (($companySummary['oilProductionFact'] - $companySummary['oilProductionFact'] * 0.019) * 241 / 1428) / 2;
            $companySummary['oilProductionPlan'] = (($companySummary['oilProductionPlan'] - $companySummary['oilProductionPlan'] * 0.019) * 241 / 1428) / 2;
            $companySummary['oilDeliveryFact'] = (($companySummary['oilDeliveryFact'] - $companySummary['oilDeliveryFact'] * 0.019) * 241 / 1428) / 2;
            $companySummary['oilDeliveryPlan'] = (($companySummary['oilDeliveryPlan'] - $companySummary['oilDeliveryPlan'] * 0.019) * 241 / 1428) / 2;
            $companySummary['productionOpek'] = (($companySummary['productionOpek'] - $companySummary['productionOpek'] * 0.019) * 241 / 1428) / 2;
            $companySummary['deliveryOpek'] = (($companySummary['deliveryOpek'] - $companySummary['deliveryOpek'] * 0.019) * 241 / 1428) / 2;
         }
         array_push($summary,$companySummary);
         return $summary;
    }

    private function getSortedById($data)
    {
        $ordered = array();
        foreach(array_keys($this->consolidatedNumberMapping) as $value) {
            $key = array_search($value, array_column($data, 'name'));
            if ($data[$key]) {
                array_push($ordered,$data[$key]);
            }
        }
        return $ordered;
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
}
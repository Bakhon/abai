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

    public function getDataByConsolidatedCategory($factData,$planData,$periodRange,$type)
    {
        $summary = array();
        $groupedFact = $factData->groupBy('dzo_name');
        $pkiSumm = array (
            'fact' => 0,
            'plan' => 0,
            'opek' => 0
        );
        if ($periodRange === 0) {
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
                return in_array(Carbon::parse($item->date)->format('d.m.Y'),$factDates) && $item->dzo === $dzoName;
            })->toArray();

            $dzo = $dzoName;
            if ($dzo === 'ПКК') {
                $dzo = 'ПККР';
            } elseif ($dzo === 'ПКИ') {
                continue;
            }
            $updated = $this->getUpdatedByTroubledCompanies($dzo,$dzoFact,$filteredPlan,$pkiSumm,$type);
            if (count($updated) > 0) {
                $summary = array_merge($summary,$updated);
            }
        }

        array_push($summary,array(
              'id' => $this->consolidatedNumberMapping[$type]['ПКИ'],
              'name' => 'ПКИ',
              'fact' => $pkiSumm['fact'],
              'plan' => $pkiSumm['plan'],
              'opek' => $pkiSumm['opek'],
        ));
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

    private function getUpdatedByTroubledCompanies($dzo,$dzoFact,$filteredPlan,&$pkiSumm,$type)
    {
        if (!array_key_exists($dzo,$this->consolidatedNumberMapping[$type])) {
            return [];
        }
        $summary = array();
        $plan = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping[$type]['plan']));

      //  $deliveryPlan = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['oilDelivery']['plan']));
        $opek = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping[$type]['opek']));
      //  $deliveryOpek = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['oilDelivery']['opek']));
        if (is_null($opek) || $opek === 0) {
            $opek = $plan;
        }
        //if (is_null($deliveryOpek)) {
      //      $deliveryOpek = $deliveryPlan;
     //   }
        $companySummary = array(
           'id' => $this->consolidatedNumberMapping[$type][$dzo],
           'name' => $dzo,
           'fact' => array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping[$type]['fact'])),
          // 'oilDeliveryFact' => array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['oilDelivery']['fact'])),
           'plan' => $plan,
        //   'oilDeliveryPlan' => $deliveryPlan,
           'opek' => $opek,
        //   'deliveryOpek' => $deliveryOpek,
           'opec_explanation_reasons' => $this->getAccidentDescription($dzoFact,'opec_explanation_reasons'),
           'impulse_explanation_reasons' => $this->getAccidentDescription($dzoFact,'impulse_explanation_reasons'),
           'shutdown_explanation_reasons' => $this->getAccidentDescription($dzoFact,'shutdown_explanation_reasons'),
           'accident_explanation_reasons' => $this->getAccidentDescription($dzoFact,'accident_explanation_reasons'),
           'restriction_kto_explanation_reasons' => $this->getAccidentDescription($dzoFact,'restriction_kto_explanation_reasons'),
           'gas_restriction_explanation_reasons' => $this->getAccidentDescription($dzoFact,'gas_restriction_explanation_reasons'),
           'other_explanation_reasons' => $this->getAccidentDescription($dzoFact,'other_explanation_reasons'),
        );

        if ($dzo === 'АГ') {
            $companySummary['fact'] = array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping[$type]['condensateFact']));
            $companySummary['plan'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping[$type]['condensatePlan']));
            $companySummary['opek'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping[$type]['condensateOpek']));
           // $companySummary['oilDeliveryFact'] = array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['condensateDelivery']['fact']));
          //  $companySummary['oilDeliveryPlan'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateDelivery']['plan']));
          //  $companySummary['deliveryOpek'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateDelivery']['opek']));
        } elseif ($dzo === 'ОМГ') {
            $condensateSummary = $companySummary;
            $condensateSummary['id'] = $this->consolidatedNumberMapping[$type]['ОМГК'];
            $condensateSummary['name'] = 'ОМГК';
            $condensateSummary['fact'] = array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping[$type]['condensateFact']));
            $condensateSummary['plan'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping[$type]['condensatePlan']));
            $condensateSummary['opek'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping[$type]['condensateOpek']));
           // $condensateSummary['oilDeliveryFact'] = array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['condensateDelivery']['fact']));
         //   $condensateSummary['oilDeliveryPlan'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateDelivery']['fact']));
          //  $condensateSummary['deliveryOpek'] = array_sum(array_column($filteredPlan,$this->consolidatedFieldsMapping['condensateDelivery']['opek']));
            array_push($summary,$condensateSummary);
        } elseif ($dzo === 'КГМ') {
            $condensateSummary = $companySummary;
            $condensateSummary['id'] = $this->consolidatedNumberMapping[$type]['КГМКМГ'];
            $condensateSummary['name'] = 'КГМКМГ';
            $condensateSummary['fact'] *= 0.5 * 0.33;
            //$condensateSummary['oilDeliveryFact'] *= 0.5 * 0.33;
            $condensateSummary['plan'] *= 0.5 * 0.33;
          //  $condensateSummary['oilDeliveryPlan'] *= 0.5 * 0.33;
            $condensateSummary['opek'] *= 0.5 * 0.33;
         //   $condensateSummary['deliveryOpek'] *= 0.5 * 0.33;
            $pkiSumm['fact'] += $condensateSummary['fact'];
            $pkiSumm['plan'] += $condensateSummary['plan'];
           // $pkiSumm['oilDeliveryFact'] += $condensateSummary['oilDeliveryFact'];
          //  $pkiSumm['oilDeliveryPlan'] += $condensateSummary['oilDeliveryPlan'];
            $pkiSumm['opek'] += $condensateSummary['opek'];
         //   $pkiSumm['deliveryOpek'] += $condensateSummary['deliveryOpek'];
            array_push($summary,$condensateSummary);
        } elseif ($dzo === 'ПККР') {
             $companySummary['fact'] *= 0.33;
             $companySummary['plan'] *= 0.33;
          //   $companySummary['oilDeliveryFact'] *= 0.33;
          //   $companySummary['oilDeliveryPlan'] *= 0.33;
             $companySummary['opek'] *= 0.33;
          //   $companySummary['deliveryOpek'] *= 0.33;
             $pkiSumm['fact'] += $companySummary['fact'];
             $pkiSumm['plan'] += $companySummary['plan'];
           //  $pkiSumm['oilDeliveryFact'] += $companySummary['oilDeliveryFact'];
         //    $pkiSumm['oilDeliveryPlan'] += $companySummary['oilDeliveryPlan'];
             $pkiSumm['opek'] += $companySummary['opek'];
          //   $pkiSumm['deliveryOpek'] += $companySummary['deliveryOpek'];
         } elseif ($dzo === 'ТП') {
             $companySummary['fact'] *= 0.5 * 0.33;
             $companySummary['plan'] *= 0.5 * 0.33;
           //  $companySummary['oilDeliveryFact'] *= 0.5 * 0.33;
          //   $companySummary['oilDeliveryPlan'] *= 0.5 * 0.33;
             $companySummary['opek'] *= 0.5 * 0.33;
         //    $companySummary['deliveryOpek'] *= 0.5 * 0.33;
             $pkiSumm['fact'] += $companySummary['fact'];
             $pkiSumm['plan'] += $companySummary['plan'];
          //   $pkiSumm['oilDeliveryFact'] += $companySummary['oilDeliveryFact'];
        //     $pkiSumm['oilDeliveryPlan'] += $companySummary['oilDeliveryPlan'];
             $pkiSumm['opek'] += $companySummary['opek'];
           //  $pkiSumm['deliveryOpek'] += $companySummary['deliveryOpek'];
         }
         if (in_array($dzo, array('ММГ','КБМ','КОА','КГМ'))) {
            $companySummary['fact'] *= 0.5;
            $companySummary['plan'] *= 0.5;
         //   $companySummary['oilDeliveryFact'] *= 0.5;
         //   $companySummary['oilDeliveryPlan'] *= 0.5;
            $companySummary['opek'] *= 0.5;
          //  $companySummary['deliveryOpek'] *= 0.5;
         }
         if ($dzo === 'ТШО') {
            $companySummary['fact'] *= 0.2;
            $companySummary['plan'] *= 0.2;
          //  $companySummary['oilDeliveryFact'] *= 0.2;
          //  $companySummary['oilDeliveryPlan'] *= 0.2;
            $companySummary['opek'] *= 0.2;
        //    $companySummary['deliveryOpek'] *= 0.2;
         }
         if ($dzo === 'КПО') {
            $companySummary['fact'] *= 0.1;
            $companySummary['plan'] *= 0.1;
          //  $companySummary['oilDeliveryFact'] *= 0.1;
         //   $companySummary['oilDeliveryPlan'] *= 0.1;
            $companySummary['opek'] *= 0.1;
         //   $companySummary['deliveryOpek'] *= 0.1;
         }
         if ($dzo === 'НКО') {
            $companySummary['fact'] = (($companySummary['fact'] - $companySummary['fact'] * 0.019) * 241 / 1428) / 2;
            $companySummary['plan'] = (($companySummary['plan'] - $companySummary['plan'] * 0.019) * 241 / 1428) / 2;
         //   $companySummary['oilDeliveryFact'] = (($companySummary['oilDeliveryFact'] - $companySummary['oilDeliveryFact'] * 0.019) * 241 / 1428) / 2;
         //   $companySummary['oilDeliveryPlan'] = (($companySummary['oilDeliveryPlan'] - $companySummary['oilDeliveryPlan'] * 0.019) * 241 / 1428) / 2;
            $companySummary['opek'] = (($companySummary['opek'] - $companySummary['opek'] * 0.019) * 241 / 1428) / 2;
          //  $companySummary['deliveryOpek'] = (($companySummary['deliveryOpek'] - $companySummary['deliveryOpek'] * 0.019) * 241 / 1428) / 2;
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
        $accidentDescription = '';
        foreach($dzoFact as $item) {
            if (!is_null($item['import_decrease_reason']) && isset($item['import_decrease_reason'][$fieldName])) {
                $accidentDescription .= $item['import_decrease_reason'][$fieldName] . '\n';
            }
        }
        return $accidentDescription;
    }
}
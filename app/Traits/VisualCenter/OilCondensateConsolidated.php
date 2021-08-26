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

    private function getDataByConsolidatedCategory($factData,$planData)
    {
        $summary = array();
        $groupedFact = $factData->groupBy('dzo_name');
        $pkiSumm = array (
            'fact' => 0,
            'plan' => 0,
            'opek' => 0
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
              'fact' => $pkiSumm['fact'],
              'plan' => $pkiSumm['plan'],
              'opek' => $pkiSumm['opek'],
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
             ->latest('date')
             ->first();
    }

    private function getUpdatedByTroubledCompanies($dzo,$dzoFact,$filteredPlan,&$pkiSumm)
    {
        $summary = array();
        $plan = array_sum(array_column($filteredPlan,$this->planField));
        $opek = array_sum(array_column($filteredPlan,$this->opekField));
        if (is_null($opek)) {
            $opek = $plan;
        }
        $companySummary = array(
           'id' => $this->consolidatedNumberMapping[$dzo],
           'name' => $dzo,
           'fact' => array_sum(array_column($dzoFact,$this->factField)),
           'plan' => $plan,
           'opek' => $opek,
        );
        if ($dzo === 'АГ') {
            $companySummary['fact'] = array_sum(array_column($dzoFact,$this->factCondensateField));
            $companySummary['plan'] = array_sum(array_column($filteredPlan,$this->planCondensateField));
            $companySummary['opek'] = array_sum(array_column($filteredPlan,$this->planCondensateField));
        } elseif ($dzo === 'ОМГ') {
            $condensateSummary = $companySummary;
            $condensateSummary['id'] = $this->consolidatedNumberMapping['ОМГК'];
            $condensateSummary['name'] = 'ОМГК';
            $condensateSummary['fact'] = array_sum(array_column($dzoFact,$this->factCondensateField));
            $condensateSummary['plan'] = array_sum(array_column($filteredPlan,$this->planCondensateField));
            $condensateSummary['opek'] = array_sum(array_column($filteredPlan,$this->planCondensateField));
            array_push($summary,$condensateSummary);
        } elseif ($dzo === 'КГМ') {
            $condensateSummary = $companySummary;
            $condensateSummary['id'] = $this->consolidatedNumberMapping['КГМКМГ'];
            $condensateSummary['name'] = 'КГМКМГ';
            $condensateSummary['fact'] *= 0.5 * 0.33;
            $condensateSummary['plan'] *= 0.5 * 0.33;
            $condensateSummary['opek'] *= 0.5 * 0.33;
            $pkiSumm['fact'] += $condensateSummary['fact'];
            $pkiSumm['plan'] += $condensateSummary['plan'];
            $pkiSumm['opek'] += $condensateSummary['opek'];
            array_push($summary,$condensateSummary);
        } elseif ($dzo === 'ПККР') {
             $companySummary['fact'] *= 0.33;
             $companySummary['plan'] *= 0.33;
             $companySummary['opek'] *= 0.33;
             $pkiSumm['fact'] += $companySummary['fact'];
             $pkiSumm['plan'] += $companySummary['plan'];
             $pkiSumm['opek'] += $companySummary['opek'];
         } elseif ($dzo === 'ТП') {
             $companySummary['fact'] *= 0.5 * 0.33;
             $companySummary['plan'] *= 0.5 * 0.33;
             $companySummary['opek'] *= 0.5 * 0.33;
             $pkiSumm['fact'] += $companySummary['fact'];
             $pkiSumm['plan'] += $companySummary['plan'];
             $pkiSumm['opek'] += $companySummary['opek'];
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
}
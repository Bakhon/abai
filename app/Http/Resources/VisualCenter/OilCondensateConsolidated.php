<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Http\Resources\VisualCenter\Dzo\Dzo;
use App\Http\Resources\VisualCenter\Dzo\Factory;
use Carbon\Carbon;

class OilCondensateConsolidated {

    protected $consolidatedNumberMapping = array (
        'production' => array (
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
        'delivery' => array (
            "ОМГ" => "1.1.",
            "ОМГК" => "",
            "ММГ" => "1.2.",
            "ЭМГ" => "1.3.",
            "КБМ" => "1.4.",
            "КГМ" => "1.5.",
            "КТМ" => "1.6.",
            "КОА" => "1.7.",
            'УО' => '1.8.',
            "ТШО" => "1.9.",
            "НКО" => "1.10.",
            'КПО' => '1.11.',
            "ПКИ" => "1.12.",
            "КГМКМГ" => "",
            "ПККР" => "",
            "ТП" => "",
            "АГ" => "1.13."
        ),
    );
    private $companies = array ('ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА','УО','ТШО','НКО','КПО','ПКИ','ПКК','ТП','АГ');

    public function getDataByConsolidatedCategory($factData,$planData,$periodRange,$type,$yearlyPlan,$periodType,$oneDzoSelected)
    {
        if (!is_null($oneDzoSelected)) {
            $this->companies = array();
            $this->companies[] = $oneDzoSelected;
        }

        $factData = $factData->filter(function($item) {
            return in_array($item->dzo_name,$this->companies);
        });


        $groupedFact = $this->getGroupedFact($factData);
        if ($periodRange === 0 && is_null($oneDzoSelected)) {
            $groupedFact = $this->getUpdatedByMissingCompanies($groupedFact);
        }

        $summary = $this->getSummary($groupedFact,$planData,$type,$periodType,$yearlyPlan,$pkiSumm);
        if (!is_null($oneDzoSelected)) {
            return $summary;
        }
        $pkiDzo = array('КГМКМГ','ТП','ПККР');
        $filteredByPki = array_filter($summary, function ($dzo) use($pkiDzo) {
            return in_array($dzo['name'],$pkiDzo);
        });
        $factory = new Factory();
        $dzo = $factory->make('ПКИ');
        $pkiSummary = $dzo->getSumByOtherDzo($filteredByPki,$periodType,$type,$this->consolidatedNumberMapping[$type]['ПКИ']);
        array_push($summary,$pkiSummary);
        $oilCondensate = new Dzo();
        $sorted = $oilCondensate->getSortedById($summary,$type,$this->consolidatedNumberMapping);
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
            $updated = $this->getUpdatedByTroubledCompanies($dzoName,$dzoFact,$filteredPlan,$type,$periodType,$yearlyPlan);
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

    private function getUpdatedByTroubledCompanies($dzoName,$dzoFact,$filteredPlan,$type,$periodType,$yearlyPlan)
    {
        $filteredYearlyPlan = $yearlyPlan->where('dzo',$dzoName);
        if ($dzoName === 'ПКК') {
            $dzoName = 'ПККР';
        }

        if (!array_key_exists($dzoName,$this->consolidatedNumberMapping[$type])) {
            return [];
        }
        $dzo = new Dzo();
        return $dzo->getSummaryByOilCondensate($dzoFact,$dzoName,$filteredPlan,$type,$periodType,$filteredYearlyPlan,$this->consolidatedNumberMapping[$type][$dzoName]);
    }

    public function getChartData($fact,$plan,$dzoName,$type,$periodRange,$periodType)
    {
        $dataType = 'production';
        if (str_contains($type, 'delivery')) {
            $dataType = 'delivery';
        }
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
        $dzo = new Dzo();
        return $dzo->getChartDataByOilCondensate($formattedPlan,$fact,$dataType,$periodRange,$periodType);
    }
}
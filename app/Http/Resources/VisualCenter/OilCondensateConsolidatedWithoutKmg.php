<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Http\Resources\VisualCenter\Dzo;
use App\Http\Resources\VisualCenter\Dzo\Factory;
use Carbon\Carbon;

class OilCondensateConsolidatedWithoutKmg {
    protected $consolidatedNumberMappingWithoutKmg = array (
        'production' => array (
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
        'delivery' => array (
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

    public function getDataByConsolidatedCategory($factData,$planData,$periodRange,$type,$yearlyPlan,$periodType,$oneDzoSelected)
    {
        if (!is_null($oneDzoSelected)) {
            $this->companies = $oneDzoSelected;
        }
        $summary = array();
        $groupedFact = $factData->groupBy('dzo_name');
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
            $updated = $this->getUpdatedByTroubledCompanies($dzoName,$dzoFact,$filteredPlan,$type,$periodType,$yearlyPlan);
            if (count($updated) > 0) {
                $summary = array_merge($summary,$updated);
            }
        }
        $oilCondensate = new Dzo();
        $sorted = $oilCondensate->getSortedById($summary,$type,$this->consolidatedNumberMappingWithoutKmg);
        return $sorted;
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
        if (!array_key_exists($dzoName,$this->consolidatedNumberMappingWithoutKmg[$type])) {
            return [];
        }
        $dzo = new Dzo();
        return $dzo->getSummaryWithoutKMG($dzoFact,$dzoName,$filteredPlan,$type,$periodType,$filteredYearlyPlan,$this->consolidatedNumberMappingWithoutKmg[$type][$dzoName]);
    }

    public function getChartData($fact,$plan,$dzoName,$type)
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

        return $this->getChartDataByOilCondensate($formattedPlan,$fact,$dataType);
    }
}
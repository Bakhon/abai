<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;

class OilCondensateConsolidatedOilResidue {
    private $consolidatedNumberMapping = array (
        "ОМГ" => "1.1.",
        "ММГ" => "1.2.",
        "ЭМГ" => "1.3.",
        "КБМ" => "1.4.",
        "КГМ" => "1.5.",
        "КТМ" => "1.6.",
        "УО" => "1.7.",
        "КОА" => "1.8."
    );
    private $companies = array('ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','УО','КОА');

    private $consolidatedFieldsMapping = array (
        'fact' => 'stock_of_goods_delivery_fact'
    );

    public function getDataByOilResidueCategory($factData,$periodRange,$oneDzoSelected)
    {
        if (!is_null($oneDzoSelected)) {
            $this->companies = array();
            $this->companies[] = $oneDzoSelected;
        }
        $summary = array();
        $groupedFact = $factData->groupBy('dzo_name');
        if ($periodRange === 0 && is_null($oneDzoSelected)) {
            $groupedFact = $this->getUpdatedByMissingCompanies($groupedFact);
        }
        foreach($groupedFact as $dzoName => $dzoFact) {
            if (!is_array($dzoFact)) {
                $dzoFact = $dzoFact->toArray();
            }
            if (!in_array($dzoName,$this->companies)) {
                continue;
            }
            $companySummary = array(
               'id' => $this->consolidatedNumberMapping[$dzoName],
               'name' => $dzoName,
               'fact' => array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['fact']))
            );
            array_push($summary,$companySummary);
        }
        $sorted = $this->getSortedById($summary);
        if (!is_null($oneDzoSelected)) {
            $sorted = $summary;
        }
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

    public function getChartData($fact,$plan,$dzoName,$type)
    {
        $companies = $this->companies;
        if (!is_null($dzoName)) {
            $fact = $fact->filter(function($item) {
                return $item->dzo_name === $dzoName;
            });
        } else {
            $fact = $fact->filter(function($item) use($companies) {
                return in_array($item->dzo_name,$companies);
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
            $daySummary['fact'] = $item[$this->consolidatedFieldsMapping['fact']];
            $daySummary['date'] = $date;
            $daySummary['name'] = $dzoName;
            array_push($chartData,$daySummary);
        }
        return $chartData;
    }
}
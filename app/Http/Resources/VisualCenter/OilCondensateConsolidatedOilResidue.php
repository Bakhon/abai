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

    public function getDataByOilResidueCategory($factData,$periodRange)
    {
        $summary = array();
        $groupedFact = $factData->groupBy('dzo_name');
        if ($periodRange === 0) {
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
               'fact' => array_sum(array_column($dzoFact,$this->consolidatedFieldsMapping['fact'])),
               'opec_explanation_reasons' => $this->getAccidentDescription($dzoFact,'opec_explanation_reasons'),
               'impulse_explanation_reasons' => $this->getAccidentDescription($dzoFact,'impulse_explanation_reasons'),
               'shutdown_explanation_reasons' => $this->getAccidentDescription($dzoFact,'shutdown_explanation_reasons'),
               'accident_explanation_reasons' => $this->getAccidentDescription($dzoFact,'accident_explanation_reasons'),
               'restriction_kto_explanation_reasons' => $this->getAccidentDescription($dzoFact,'restriction_kto_explanation_reasons'),
               'gas_restriction_explanation_reasons' => $this->getAccidentDescription($dzoFact,'gas_restriction_explanation_reasons'),
               'other_explanation_reasons' => $this->getAccidentDescription($dzoFact,'other_explanation_reasons'),
            );
            array_push($summary,$companySummary);
        }
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
             ->where('dzo_name',$dzoName)
             ->whereNull('is_corrected')
             ->with('importDecreaseReason')
             ->latest('date')
             ->first();
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
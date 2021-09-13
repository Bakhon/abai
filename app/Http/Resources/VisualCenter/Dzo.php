<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;

class Dzo {
    private $oilCondensateTemplate = array(
        'id' => '',
        'name' => '',
        'fact' => 0,
        'plan' => 0,
        'opek' => 0,
        'condensatePlan' => 0,
        'condensateFact' => 0,
        'condensateOpek' => 0,
        'decreaseReasonExplanations' => []
    );

    protected $consolidatedFieldsMapping = array (
        'production' => array(
            'fact' => 'oil_production_fact',
            'plan' => 'plan_oil',
            'opek' => 'plan_oil_opek',
            'condensateFact' => 'condensate_production_fact',
            'condensatePlan' => 'plan_kondensat',
            'condensateOpek' => 'plan_kondensat'
        ),
        'delivery' => array (
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

    private $dzoMultiplier = array (
        'ПКК' => 0.33,
        'КГМ' => 0.5 * 0.33,
        'ТП' => 0.5 * 0.33,
        'НКО' => ((1 - 0.019) * 241 / 1428) / 2
    );

    private $dzoMapping = array();

    protected $decreaseReasonFields = array (
        'opec_explanation_reasons',
        'impulse_explanation_reasons',
        'shutdown_explanation_reasons',
        'accident_explanation_reasons',
        'restriction_kto_explanation_reasons',
        'gas_restriction_explanation_reasons',
        'other_explanation_reasons'
    );

    private function initializeDzo()
    {
        $this->dzoMapping = array (
            'АГ' => new Ag(),
            'ПКИ' => new Pki(),
            'ОМГ' => new Omg(),
            'КГМ' => new Kgm(),
            'ПККР' => new Pkkr(),
            'ТП' => new Tp(),
            'ММГ' => new Mmg(),
            'КБМ' => new Kbm(),
            'КОА' => new Koa(),
            'КПО' => new Kpo(),
            'НКО' => new Nko(),
            'ТШО' => new Tsho()
        );
    }

    protected function getSummaryByOilCondensate($dzoFact,$dzoName,$filteredPlan,&$pkiSumm,$type,$periodType,$filteredYearlyPlan)
    {
        $this->initializeDzo();
        $daysInMonth = Carbon::parse($dzoFact[0]['date'])->daysInMonth;
        $companySummary = $this->oilCondensateTemplate;
        $companySummary['id'] = $this->consolidatedNumberMapping[$type][$dzoName];
        $companySummary['name'] = $dzoName;
        $companySummary['fact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['fact']);
        $companySummary['plan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']);
        $companySummary['opek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['opek']);
        $companySummary['condensatePlan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensatePlan']);
        $companySummary['condensateFact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['condensateFact']);
        $companySummary['condensateOpek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensateOpek']);

        if ($periodType === 'day') {
            $companySummary['decreaseReasonExplanations'] = $this->getAccidentDescription($dzoFact);
        }
        if ($periodType === 'month') {
            $companySummary = $this->getUpdatedForMonthPeriod($companySummary,$filteredPlan,$type,$daysInMonth);
        }
        if ($periodType === 'year') {
            $companySummary = $this->getUpdatedForYearPeriod($companySummary,$filteredPlan,$type,$daysInMonth,$filteredYearlyPlan);
        }
        $condensateSummary = $companySummary;

        if ($dzoName === 'АГ') {
            $companySummary = $this->dzoMapping[$dzoName]->getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$this->consolidatedFieldsMapping[$type]['condensatePlan'],$periodType);
        }
        if ($dzoName === 'ОМГ') {
            $condensateSummary = $this->dzoMapping[$dzoName]->getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$this->consolidatedFieldsMapping[$type]['condensatePlan'],$periodType);
        }
        if ($dzoName === 'КГМ') {
            $condensateSummary = $this->dzoMapping[$dzoName]->getCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$periodType);
            $pkiSumm = $this->dzoMapping['ПКИ']->getOilCondensateCalculated($condensateSummary,$pkiSumm,$periodType);
        }
        if ($dzoName === 'ПККР') {
            $companySummary = $this->dzoMapping[$dzoName]->getOilCondensateCalculated($companySummary,$periodType);
            $pkiSumm = $this->dzoMapping['ПКИ']->getOilCondensateCalculated($companySummary,$pkiSumm,$periodType);
        }
        if ($dzoName === 'ТП') {
            $companySummary = $this->dzoMapping[$dzoName]->getOilCondensateCalculated($companySummary,$periodType);
            $pkiSumm = $this->dzoMapping['ПКИ']->getOilCondensateCalculated($companySummary,$pkiSumm,$periodType);
        }
        if (in_array($dzoName, array('ММГ','КБМ','КОА','КГМ','ТШО','КПО','НКО'))) {
            $companySummary = $this->dzoMapping[$dzoName]->getOilCondensateCalculated($companySummary,$periodType);
        }
        if (is_null($companySummary['opek']) || $companySummary['opek'] == 0) {
            $companySummary['opek'] = $companySummary['plan'];
        }
        if (is_null($condensateSummary['opek']) || $condensateSummary['opek'] == 0) {
            $condensateSummary['opek'] = $condensateSummary['plan'];
        }
        $summary = array();
        if (in_array($dzoName, array('КГМ','ОМГ'))) {
            array_push($summary,$condensateSummary);
        }
        array_push($summary,$companySummary);

        return $summary;
    }

    protected function getSummaryWithoutKMG($dzoFact,$dzoName,$filteredPlan,&$pkiSumm,$type,$periodType,$filteredYearlyPlan)
    {
        $this->initializeDzo();
        $summary = array();
        $daysInMonth = Carbon::parse($dzoFact[0]['date'])->daysInMonth;
        $companySummary = $this->oilCondensateTemplate;
        $companySummary['id'] = $this->consolidatedNumberMappingWithoutKmg[$type][$dzoName];
        $companySummary['name'] = $dzoName;
        $companySummary['fact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['fact']);
        $companySummary['plan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']);
        $companySummary['opek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['opek']);
        $companySummary['condensatePlan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensatePlan']);
        $companySummary['condensateFact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['condensateFact']);
        $companySummary['condensateOpek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensateOpek']);

        if ($periodType === 'day') {
            $companySummary['decreaseReasonExplanations'] = $this->getAccidentDescription($dzoFact);
        }
        if ($periodType === 'month') {
            $companySummary = $this->getUpdatedForMonthPeriod($companySummary,$filteredPlan,$type,$daysInMonth);
        }
        if ($periodType === 'year') {
            $companySummary = $this->getUpdatedForYearPeriod($companySummary,$filteredPlan,$type,$daysInMonth,$filteredYearlyPlan);
        }
        $condensateSummary = $companySummary;

        if ($dzoName === 'АГ') {
            $companySummary = $this->dzoMapping[$dzoName]->getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$this->consolidatedFieldsMapping[$type]['condensatePlan'],$periodType);
        }
        if ($dzoName === 'ОМГ') {
            $condensateSummary = $this->dzoMapping[$dzoName]->getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$this->consolidatedFieldsMapping[$type]['condensatePlan'],$periodType);
        }
        if (is_null($companySummary['opek']) || $companySummary['opek'] == 0) {
             $companySummary['opek'] = $companySummary['plan'];
        }
        if (is_null($condensateSummary['opek']) || $condensateSummary['opek'] == 0) {
             $condensateSummary['opek'] = $condensateSummary['plan'];
        }
        if ($dzoName === 'ОМГ') {
            array_push($summary,$condensateSummary);
        }
        array_push($summary,$companySummary);
        return $summary;
    }

    protected function getYearlyPlanBy($yearlyPlan,$fieldName)
    {
        $summary = 0;
        foreach($yearlyPlan as $monthly) {
            $summary += $monthly[$fieldName] * Carbon::parse($monthly['date'])->daysInMonth;
        }
        return $summary;
    }

    protected function getCurrentPlanForYear($filteredPlan,$fieldName,$type)
    {
        $summaryPlan = 0;
        foreach($filteredPlan as $monthlyPlan) {
            if (Carbon::parse($monthlyPlan['date'])->month < Carbon::now()->month) {
                $summaryPlan += $monthlyPlan[$this->consolidatedFieldsMapping[$type][$fieldName]] * Carbon::parse($monthlyPlan['date'])->daysInMonth;
            }
            if (Carbon::parse($monthlyPlan['date'])->month === Carbon::now()->month) {
                $summaryPlan += $monthlyPlan[$this->consolidatedFieldsMapping[$type][$fieldName]] * Carbon::now()->day - 1;
            }
        }
        return $summaryPlan;
    }

    protected function getChartDataByOilCondensate($formattedPlan,$fact,$type)
    {
        $this->initializeDzo();
        $chartData = array();
        foreach($fact as $item) {
            $date = Carbon::parse($item['date'])->startOfDay()->format('d/m/Y');
            $daySummary = array();
            $formattedDate = Carbon::parse($item['date'])->copy()->firstOfMonth()->startOfDay()->format('d/m/Y');
            $dzoName = $item['dzo_name'];
            $planRecord = $formattedPlan[$formattedDate][$dzoName];
            $daySummary['fact'] = $item[$this->consolidatedFieldsMapping[$type]['fact']];
            $daySummary['plan'] = $planRecord[$this->consolidatedFieldsMapping[$type]['plan']];
            $daySummary['opek'] = $planRecord[$this->consolidatedFieldsMapping[$type]['opek']];
            $daySummary['date'] = $date;
            $daySummary['name'] = $dzoName;
            if ($dzoName === 'ОМГ') {
                $condensateSummary = $this->dzoMapping[$dzoName]->getChartData(
                    $planRecord,
                    $date,
                    $item,
                    $this->consolidatedFieldsMapping[$type]['condensateFact'],
                    $this->consolidatedFieldsMapping[$type]['condensatePlan'],
                    $this->consolidatedFieldsMapping[$type]['condensateOpek']
                );
                array_push($chartData,$condensateSummary);
            }
            if ($dzoName === 'АГ') {
                $daySummary = $this->dzoMapping[$dzoName]->getChartData(
                    $daySummary,
                    $item,
                    $planRecord,
                    $this->consolidatedFieldsMapping[$type]['condensateFact'],
                    $this->consolidatedFieldsMapping[$type]['condensatePlan'],
                    $this->consolidatedFieldsMapping[$type]['condensateOpek']
                );
            }
            if ($daySummary['opek'] == 0) {
                $daySummary['opek'] = $daySummary['plan'];
            }
            if (array_key_exists($dzoName,$this->dzoMultiplier)) {
                $daySummary['fact'] *= $this->dzoMultiplier[$dzoName];
                $daySummary['plan'] *= $this->dzoMultiplier[$dzoName];
                $daySummary['opek'] *= $this->dzoMultiplier[$dzoName];
            }
            array_push($chartData,$daySummary);
        }
        return $chartData;
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

    protected function getSortedById($data,$type,$numberMapping)
    {
        $ordered = array();
        foreach(array_keys($numberMapping[$type]) as $value) {
            $key = array_search($value, array_column($data, 'name'));
            if ($data[$key]) {
                array_push($ordered,$data[$key]);
            }
        }
        return $ordered;
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
}
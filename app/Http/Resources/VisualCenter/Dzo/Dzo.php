<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Http\Resources\VisualCenter\Dzo\Factory;
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
    private $yearlyPlans = array (
        'production' => array(
            'fact' => 'oil_production_fact',
            'plan' => 'oil_plan',
            'opek' => 'oil_opek_plan',
            'condensateFact' => 'condensate_production_fact',
            'condensatePlan' => 'gk_plan',
            'condensateOpek' => 'gk_plan'
        ),
        'delivery' => array (
            'fact' => 'oil_delivery_fact',
            'plan' => 'oil_dlv_plan',
            'opek' => 'oil_dlv_opek_plan',
            'condensateFact' => 'condensate_delivery_fact',
            'condensatePlan' => 'gk_plan',
            'condensateOpek' => 'gk_plan'
        ),
        'gasProduction' => array(
            'naturalFact' => 'natural_gas_production_fact',
            'associatedFact' => 'associated_gas_production_fact',
            'naruralPlan' => 'dobycha_gaza_prirod_plan',
            'associatedPlan' => 'plan_poput_gas'
        ),
    );

    private $dzoMultiplier = array (
        'ПКК' => 0.33,
        'КГМ' => 0.5 * 0.33,
        'ТП' => 0.5 * 0.33,
        'НКО' => ((1 - 0.019) * 241 / 1428) / 2
    );

    protected $decreaseReasonFields = array (
        'opec_explanation_reasons' => 'opec_oil_losses',
        'impulse_explanation_reasons' => 'impulse_oil_losses',
        'shutdown_explanation_reasons' => 'shutdown_oil_losses',
        'accident_explanation_reasons' => 'accident_oil_losses',
        'restriction_kto_explanation_reasons' => 'restriction_kto_oil_losses',
        'gas_restriction_explanation_reasons' => 'gas_restriction_oil_losses',
        'other_explanation_reasons' => 'other_oil_losses'
    );

    protected $dzoName;

    public function getSummaryByOilCondensate($dzoFact,$dzoName,$filteredPlan,$type,$periodType,$filteredYearlyPlan,$dzoId,$periodEnd)
    {
        $daysInMonth = Carbon::parse($dzoFact[0]['date'])->daysInMonth;
        $companySummary = $this->oilCondensateTemplate;
        $companySummary['id'] = $dzoId;
        $companySummary['name'] = $dzoName;
        $companySummary['fact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['fact']);
        $companySummary['plan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']);
        $companySummary['opek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['opek']);
        $companySummary['condensatePlan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensatePlan']);
        $companySummary['condensateFact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['condensateFact']);
        $companySummary['condensateOpek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensateOpek']);
        $companySummary['opek'] = $this->getOpekUpdatedByPlan($companySummary['plan'],$companySummary['opek']);
        $companySummary['condensateOpek'] = $this->getOpekUpdatedByPlan($companySummary['condensatePlan'],$companySummary['condensateOpek']);

        if ($periodType === 'day') {
            $companySummary['decreaseReasonExplanations'] = $this->getAccidentDescription($dzoFact);
        }
        if ($periodType === 'month') {
            $companySummary = $this->getUpdatedForMonthPeriod($companySummary,$filteredPlan,$type,$daysInMonth);
        }
        if ($periodType === 'year') {
            $companySummary = $this->getUpdatedForYearPeriod($companySummary,$filteredPlan,$type,$daysInMonth,$filteredYearlyPlan);
            $companySummary['plan'] = $this->getPlanByYear($filteredPlan,$this->consolidatedFieldsMapping[$type]['plan'],$periodEnd);
            $companySummary['opek'] = $this->getPlanByYear($filteredPlan,$this->consolidatedFieldsMapping[$type]['opek'],$periodEnd);
        }
        $factory = new Factory();
        $dzo = $factory->make($dzoName);
        $companySummary = $dzo->getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodEnd);
        return $companySummary;
    }

    protected function getPlanByYear($plans,$fieldName,$periodEnd)
    {
        $summary = 0;
        foreach($plans as $plan) {
            $date = Carbon::parse($plan['date']);
            $daysInMonth = $date->daysInMonth;
            if ($periodEnd->month === $date->month && $periodEnd->year === $date->year) {
                $daysInMonth = $periodEnd->day;
            }
            $summary += $plan[$fieldName] * $daysInMonth;
        }
        return $summary;
    }

    protected function getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodEnd)
    {

    }

    public function getOpekUpdatedByPlan($plan,$opek)
    {
        $updatedOpek = $opek;
        if (is_null($opek) || $opek == 0) {
            $updatedOpek = $plan;
        }
        return $updatedOpek;
    }

    public function getSummaryWithoutKMG($dzoFact,$dzoName,$filteredPlan,$type,$periodType,$filteredYearlyPlan,$dzoId,$periodEnd)
    {
        $summary = array();
        $daysInMonth = Carbon::parse($dzoFact[0]['date'])->daysInMonth;
        $companySummary = $this->oilCondensateTemplate;
        $companySummary['id'] = $dzoId;
        $companySummary['name'] = $dzoName;
        $companySummary['fact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['fact']);
        $companySummary['plan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']);
        $companySummary['opek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['opek']);
        $companySummary['condensatePlan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensatePlan']);
        $companySummary['condensateFact'] = $dzoFact->sum($this->consolidatedFieldsMapping[$type]['condensateFact']);
        $companySummary['condensateOpek'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['condensateOpek']);
        $companySummary['opek'] = $this->getOpekUpdatedByPlan($companySummary['plan'],$companySummary['opek']);
        $companySummary['condensateOpek'] = $this->getOpekUpdatedByPlan($companySummary['condensatePlan'],$companySummary['condensateOpek']);

        if ($periodType === 'day') {
            $companySummary['decreaseReasonExplanations'] = $this->getAccidentDescription($dzoFact);
        }
        if ($periodType === 'month') {
            $companySummary = $this->getUpdatedForMonthPeriod($companySummary,$filteredPlan,$type,$daysInMonth);
        }
        if ($periodType === 'year') {
            $companySummary = $this->getUpdatedForYearPeriod($companySummary,$filteredPlan,$type,$daysInMonth,$filteredYearlyPlan);
            $companySummary['plan'] = $this->getPlanByYear($filteredPlan,$this->consolidatedFieldsMapping[$type]['plan'],$periodEnd);
            $companySummary['opek'] = $this->getPlanByYear($filteredPlan,$this->consolidatedFieldsMapping[$type]['opek'],$periodEnd);
        }

        $factory = new Factory();
        $dzo = $factory->make($dzoName);
        $summary = $dzo->getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodType,$periodEnd);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodType,$periodEnd)
    {

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

    public function getChartDataByOilCondensate($formattedPlan,$fact,$type,$periodRange,$periodType,$isSummary)
    {
        $chartData = array();

        foreach($fact as $item) {
            $date = Carbon::parse($item['date'])->startOfDay()->format('d/m/Y');
            $daySummary = array(
                'plan' => 0,
                'fact' => 0,
                'opek' => 0
            );
            $formattedDate = Carbon::parse($item['date'])->copy()->firstOfMonth()->startOfDay()->format('d/m/Y');
            $dzoName = $item['dzo_name'];
            $daySummary['fact'] = $item[$this->consolidatedFieldsMapping[$type]['fact']];
            $planRecord = array(
                'plan_oil' => 0,
                'plan_oil_opek' => 0,
                'plan_kondensat' => 0
            );

            if (count($formattedPlan) !== 0 && array_key_exists($dzoName,$formattedPlan[$formattedDate])) {
                $planRecord = $formattedPlan[$formattedDate][$dzoName];
            }
            if ($periodType === 'year') {
                $daySummary['plan'] = $planRecord[$this->consolidatedFieldsMapping[$type]['plan']];
                $daySummary['opek'] = $planRecord[$this->consolidatedFieldsMapping[$type]['opek']];
            } else {
                $daySummary['plan'] = $planRecord[$this->consolidatedFieldsMapping[$type]['plan']] / $periodRange;
                $daySummary['opek'] = $planRecord[$this->consolidatedFieldsMapping[$type]['opek']] / $periodRange;
            }

            $daySummary['date'] = $date;
            $daySummary['opek'] = $this->getOpekUpdatedByPlan($daySummary['plan'],$daySummary['opek']);
            if ($dzoName === 'ПКК') {
                $dzoName = 'ПККР';
            }
            $daySummary['name'] = $dzoName;
            $factory = new Factory();
            $dzo = $factory->make($dzoName);
            $summary = $dzo->getChartData($daySummary,$planRecord,$date,$item,$this->consolidatedFieldsMapping[$type]['condensateFact'],$this->consolidatedFieldsMapping[$type]['condensatePlan'],$this->consolidatedFieldsMapping[$type]['condensateOpek'],$isSummary);
            $chartData = array_merge($chartData,$summary);
        }

        return $chartData;
    }

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField,$isSummary)
    {

    }

    protected function getAccidentDescription($dzoFact)
    {
        $accidents = array();
        $dzoFactData = $dzoFact[0];
        foreach($this->decreaseReasonFields as $fieldName => $key) {
            if (!is_null($dzoFactData['importDecreaseReason']) && !is_null($dzoFactData['importDecreaseReason'][$fieldName])) {
               array_push($accidents,array($dzoFactData['importDecreaseReason'][$fieldName],$dzoFactData['importDecreaseReason'][$key]));
            }
        }
        return $accidents;
    }

    protected function getUpdatedForMonthPeriod($companySummary,$filteredPlan,$type,$daysInMonth)
    {
        $summary = $companySummary;
        $summary['monthlyPlan'] = $filteredPlan->sum($this->consolidatedFieldsMapping[$type]['plan']) * $daysInMonth;
        return $summary;
    }

    protected function getUpdatedForYearPeriod($companySummary,$filteredPlan,$type,$daysInMonth,$filteredYearlyPlan)
    {
        $planFieldName = 'plan';
        $condensateCompanies = ['АГ','ОМГК'];
        if (in_array($companySummary['name'],$condensateCompanies)) {
            $planFieldName = 'condensatePlan';
        }
        $summary = $companySummary;

        $summary['yearlyPlan'] = $filteredYearlyPlan->first()->oil_plan;
        $summary['condensatePlan'] = $this->getCurrentPlanForYear($filteredPlan,'condensatePlan',$type);
        $summary['condensateOpek'] = $this->getCurrentPlanForYear($filteredPlan,'condensateOpek',$type);
        return $summary;
    }

    public function getSortedById($data,$type,$numberMapping)
    {
        $ordered = array();
        foreach(array_keys($numberMapping[$type]) as $value) {
            $key = array_search($value, array_column($data, 'name'));
            if ($key !== FALSE && $data[$key]) {
                array_push($ordered,$data[$key]);
            }
        }
        return $ordered;
    }
}
<?php

namespace App\Http\Controllers\VisCenter\ProductionParams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\DzoPlan;
use App\Http\Resources\VisualCenter\OilCondensateConsolidated;
use App\Http\Resources\VisualCenter\OilCondensateConsolidatedWithoutKmg;
use App\Http\Resources\VisualCenter\OilCondensateConsolidatedOilResidue;
use App\Http\Resources\VisualCenter\GasProduction;
use App\Http\Resources\VisualCenter\WaterInjection;
use Carbon\Carbon;

class VisualCenterController extends Controller
{
    private $periodStart = '';
    private $periodEnd = '';
    private $periodRange = 0;
    private $periodType = 'day';
    private $historicalPeriodStart = '';
    private $historicalPeriodEnd = '';
    private $dzoName = '';
    private $category = '';
    private $filter = '';
    private $yearlyPlan = array();
    private $chartData = array();
    private $tableData = array(
        'current' => array(
            'oilCondensateProduction' => array(),
            'oilCondensateProductionWithoutKMG' => array(),
            'oilCondensateDelivery' => array(),
            'oilCondensateDeliveryWithoutKMG' => array(),
            'oilCondensateDeliveryOilResidue' => array(),
        ),
        'historical' => array(
            'oilCondensateProduction' => array(),
            'oilCondensateProductionWithoutKMG' => array(),
            'oilCondensateDelivery' => array(),
            'oilCondensateDeliveryWithoutKMG' => array(),
        )
    );
    private $isOpek = false;

    public function getProductionParamsByCategory(Request $request)
    {
        $this->chartData = $this->tableData;
        $this->refreshRequestParams($request->request);
        $this->yearlyPlan = $this->getYearlyPlan();
        $currentPeriodDzoFact = $this->getDzoFact($this->periodStart,$this->periodEnd);
        $currentPeriodDzoPlan = $this->getDzoPlan($this->periodStart,$this->periodEnd);
        $historicalDzoFact = $this->getDzoFact($this->historicalPeriodStart,$this->historicalPeriodEnd);
        $historicalDzoPlan = $this->getDzoPlan($this->historicalPeriodStart,$this->historicalPeriodEnd);
        $outputData = $this->getData($currentPeriodDzoFact,$currentPeriodDzoPlan,$historicalDzoFact,$historicalDzoPlan);
        $this->tableData = $outputData['table'];
        $this->chartData = $outputData['chart'];
        return array(
            'tableData' => $this->tableData,
            'chartData' => $this->chartData,
        );
    }

    private function refreshRequestParams($params)
    {
        $this->periodStart = Carbon::parse($params->get('periodStart'))->startOfDay();
        $this->periodEnd = Carbon::parse($params->get('periodEnd'))->endOfDay();
        $this->periodRange = (int)$params->get('periodRange');
        $this->periodType = $params->get('periodType');
        $this->historicalPeriodStart = Carbon::parse($params->get('historicalPeriodStart'))->startOfDay();
        $this->historicalPeriodEnd = Carbon::parse($params->get('historicalPeriodEnd'))->endOfDay();
        $this->dzoName = $params->get('dzoName');
        $this->category = $params->get('category');
        $this->isOpek = $this->category === 'oilCondensateProduction' || $this->category === 'oilCondensateDelivery';
    }

    private function getDzoFact($startDate,$endDate)
    {
        $query = DzoImportData::query()
             ->whereDate('date', '>=', $startDate)
             ->whereDate('date', '<=', $endDate)
             ->whereNull('is_corrected');
        if (!is_null($this->dzoName)) {
            $query->where('dzo_name', $this->dzoName);
        }
        return $query->orderBy('date', 'asc')->with('importDecreaseReason')->get();
    }
    private function getDzoPlan($startDate,$endDate)
    {
        $query = DzoPlan::query()
            ->whereDate('date', '>=', $startDate->firstOfMonth()->startOfDay())
            ->whereDate('date', '<=', $endDate->firstOfMonth()->startOfDay());
        if (!is_null($this->dzoName)) {
            $query->where('dzo', $this->dzoName);
        }
        return $query->orderBy('date', 'asc')->get();
    }

    private function getData($fact,$plan,$historicalFact,$historicalPlan)
    {
        $categoryMapping = array (
            'oilCondensateProduction' => new OilCondensateConsolidated(),
            'oilCondensateDelivery' => new OilCondensateConsolidated(),
            'oilCondensateProductionWithoutKMG' => new OilCondensateConsolidatedWithoutKmg(),
            'oilCondensateDeliveryWithoutKMG' => new OilCondensateConsolidatedWithoutKmg(),
            'oilCondensateDeliveryOilResidue' => new OilCondensateConsolidatedOilResidue(),
            'gasProduction' => new GasProduction(),
            'naturalGasProduction' => new GasProduction(),
            'associatedGasProduction' => new GasProduction(),
            'associatedGasFlaring' => new GasProduction(),
            'naturalGasDelivery' => new GasProduction(),
            'expensesForOwnNaturalGas' => new GasProduction(),
            'associatedGasDelivery' => new GasProduction(),
            'expensesForOwnAssociatedGas' => new GasProduction(),
            'waterInjection' => new WaterInjection(),
            'seaWaterInjection' => new WaterInjection(),
            'wasteWaterInjection' => new WaterInjection(),
            'artezianWaterInjection' => new WaterInjection(),
        );
        $chartData = array();

        if ($this->periodRange > 0) {
            $chartData = $categoryMapping[$this->category]->getChartData($fact,$plan,$this->dzoName,$this->category);
        }
        return array (
            'table' => $this->getTableData($categoryMapping,$fact,$plan,$historicalFact,$historicalPlan),
            'chart' => $chartData
        );
    }

    private function getTableData($categoryMapping,$fact,$plan,$historicalFact,$historicalPlan)
    {
        $tableData = array();
        $tableData['current']['oilCondensateProduction'] = $categoryMapping['oilCondensateProduction']->getDataByConsolidatedCategory($fact,$plan,$this->periodRange,'production',$this->yearlyPlan,$this->periodType,$this->dzoName);
        $tableData['historical']['oilCondensateProduction'] = $categoryMapping['oilCondensateProduction']->getDataByConsolidatedCategory($historicalFact,$historicalPlan,$this->periodRange,'production',$this->yearlyPlan,$this->periodType,$this->dzoName);
        $tableData['current']['oilCondensateDelivery'] = $categoryMapping['oilCondensateDelivery']->getDataByConsolidatedCategory($fact,$plan,$this->periodRange,'delivery',$this->yearlyPlan,$this->periodType,$this->dzoName);
        $tableData['historical']['oilCondensateDelivery'] = $categoryMapping['oilCondensateDelivery']->getDataByConsolidatedCategory($historicalFact,$historicalPlan,$this->periodRange,'delivery',$this->yearlyPlan,$this->periodType,$this->dzoName);
        $tableData['current']['oilCondensateProductionWithoutKMG'] = $categoryMapping['oilCondensateProductionWithoutKMG']->getDataByConsolidatedCategory($fact,$plan,$this->periodRange,'production',$this->yearlyPlan,$this->periodType,$this->dzoName);
        $tableData['current']['oilCondensateDeliveryWithoutKMG'] = $categoryMapping['oilCondensateDeliveryWithoutKMG']->getDataByConsolidatedCategory($fact,$plan,$this->periodRange,'delivery',$this->yearlyPlan,$this->periodType,$this->dzoName);
        $tableData['historical']['oilCondensateProductionWithoutKMG'] = $categoryMapping['oilCondensateProductionWithoutKMG']->getDataByConsolidatedCategory($historicalFact,$historicalPlan,$this->periodRange,'production',$this->yearlyPlan,$this->periodType,$this->dzoName);
        $tableData['historical']['oilCondensateDeliveryWithoutKMG'] = $categoryMapping['oilCondensateDeliveryWithoutKMG']->getDataByConsolidatedCategory($historicalFact,$historicalPlan,$this->periodRange,'delivery',$this->yearlyPlan,$this->periodType,$this->dzoName);
        $tableData['current'] = array_merge($tableData['current'],$categoryMapping['gasProduction']->getDataByCategory($fact,$plan,$this->periodRange,$this->yearlyPlan,$this->periodType,$this->dzoName));
        $tableData['historical'] = array_merge($tableData['historical'],$categoryMapping['gasProduction']->getDataByCategory($historicalFact,$historicalPlan,$this->periodRange,$this->yearlyPlan,$this->periodType,$this->dzoName));
        if ($this->category === 'oilCondensateDeliveryOilResidue') {
            $tableData['current']['oilCondensateDeliveryOilResidue'] = $categoryMapping['oilCondensateDeliveryOilResidue']->getDataByOilResidueCategory($fact,$this->periodRange,$this->dzoName);
        }
        if (str_contains(strtolower($this->category), 'water')) {
            $tableData['current'] = array_merge($tableData['current'], $categoryMapping['waterInjection']->getDataByCategory($fact,$plan,$this->periodRange,$this->yearlyPlan,$this->periodType,$this->dzoName));
        }
        return $tableData;
    }

    private function getYearlyPlan()
    {
        $query = DzoPlan::query()
            ->whereYear('date', $this->periodStart->year);
        if (!is_null($this->dzoName)) {
            $query->where('dzo', $this->dzoName);
        }
        return $query->orderBy('date', 'asc')->get();
    }
}

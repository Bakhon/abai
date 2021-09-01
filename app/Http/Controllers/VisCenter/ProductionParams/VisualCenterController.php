<?php

namespace App\Http\Controllers\VisCenter\ProductionParams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\DzoPlan;
use App\Http\Resources\VisualCenter\OilCondensateConsolidated;
use Carbon\Carbon;

class VisualCenterController extends Controller
{
    private $periodStart = '';
    private $periodEnd = '';
    private $periodRange = 0;
    private $historicalPeriodStart = '';
    private $historicalPeriodEnd = '';
    private $dzoName = '';
    private $category = '';
    private $filter = '';
    private $chartData = array();
    private $tableData = array(
        'current' => array(
            'oilCondensateProduction' => array(),
            'oilCondensateProductionWithoutKMG' => array(),
            'oilCondensateDelivery' => array(),
            'oilCondensateDeliveryWithoutKMG' => array(),
            'oilCondensateDeliveryOilResidue' => array(),
            'gasProduction' => array(),
            'naturalGasProduction' => array(),
            'associatedGasProduction' => array(),
            'flaringGas' => array(),
            'naturalGasDelivery' => array(),
            'expensesForOwnNaturalGas' => array(),
            'associatedGasDelivery' => array(),
            'expensesForOwnAssociatedGas' => array(),
            'waterInjection' => array(),
            'seawaterInjection' => array(),
            'wasteWaterInjection' => array(),
            'artezianWaterInjection' => array()
        ),
        'historical' => array(
            'oilCondensateProduction' => array(),
            'oilCondensateProductionWithoutKMG' => array(),
            'oilCondensateDelivery' => array(),
            'oilCondensateDeliveryWithoutKMG' => array(),
            'gasProduction' => array()
        )
    );
    private $isOpek = false;
    protected $factFields = [
        'id',
        'dzo_name',
        'oil_production_fact',
        'oil_delivery_fact',
        'condensate_production_fact',
        'condensate_delivery_fact',
        'stock_of_goods_delivery_fact',
        'natural_gas_production_fact',
        'natural_gas_delivery_fact',
        'natural_gas_expenses_for_own_fact',
        'associated_gas_production_fact',
        'associated_gas_flaring_fact',
        'associated_gas_delivery_fact',
        'associated_gas_expenses_for_own_fact',
        'agent_upload_seawater_injection_fact',
        'agent_upload_waste_water_injection_fact',
        'agent_upload_albsenomanian_water_injection_fact'
    ];
    protected $planFields = [
        'dzo',
        'plan_oil',
        'plan_oil_opek',
        'plan_oil_dlv',
        'plan_oil_dlv_opek',
        'plan_kondensat',
        'plan_kondensat_dlv',
        'plan_prirod_gas',
        'plan_prirod_gas_dlv',
        'plan_prirod_gas_raskhod',
        'plan_poput_gas',
        'plan_poput_gas_burn',
        'plan_poput_gas_dlv',
        'plan_poput_gas_raskhod',
        'plan_liq_ocean',
        'plan_liq_waste',
        'plan_liq_albsen'
    ];

    public function getProductionParamsByCategory(Request $request)
    {
        $this->chartData = $this->tableData;
        $this->refreshRequestParams($request->request);
        $currentPeriodDzoFact = $this->getDzoFact($this->periodStart,$this->periodEnd);
        $currentPeriodDzoPlan = $this->getDzoPlan($this->periodStart,$this->periodEnd);
        $historicalDzoFact = $this->getDzoFact($this->historicalPeriodStart,$this->historicalPeriodEnd);
        $historicalDzoPlan = $this->getDzoPlan($this->historicalPeriodStart,$this->historicalPeriodEnd);
        if ($this->periodRange > 0) {
            //$this->chartData = $this->getChartData($currentPeriodDzoFact,$currentPeriodDzoPlan);
        }
        $this->tableData['current']['oilCondensateProduction'] = $this->getTableData($currentPeriodDzoFact,$currentPeriodDzoPlan,'oilCondensateProduction');
        $this->tableData['historical']['oilCondensateProduction'] = $this->getTableData($historicalDzoFact,$historicalDzoPlan,'oilCondensateProduction');
        $this->tableData['current']['oilCondensateDelivery'] = $this->getTableData($currentPeriodDzoFact,$currentPeriodDzoPlan,'oilCondensateDelivery');
        $this->tableData['historical']['oilCondensateDelivery'] = $this->getTableData($historicalDzoFact,$historicalDzoPlan,'oilCondensateProduction');
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
        $this->historicalPeriodStart = Carbon::parse($params->get('historicalPeriodStart'))->startOfDay();
        $this->historicalPeriodEnd = Carbon::parse($params->get('historicalPeriodEnd'))->endOfDay();
        $this->dzoName = $params->get('dzoName');
        $this->category = $params->get('category');
        $this->filter = $params->get('filter');
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
            $query->where('dzo_name', $this->dzoName);
        }
        return $query->orderBy('date', 'asc')->get();
    }

    private function getChartData($fact,$plan)
    {
        $groupedFact = $fact->groupBy('date');
        $sum = array();
        foreach($groupedFact as $date => $dailyFact) {
            $sum[$date]['time'] = Carbon::parse($date)->format('d.m.Y');
            $sum[$date]['fact'] = array_sum(array_column($dailyFact->toArray(),$this->factField));
            $monthStartDate = Carbon::parse($date)->copy()->firstOfMonth()->format('d.m.Y');
            $planRecords = $plan->where('dates',$monthStartDate);
            $sum[$date]['plan'] = array_sum(array_column($planRecords->toArray(),$this->planField));
            if ($this->isOpek) {
                $sum[$date]['opek'] = array_sum(array_column($planRecords->toArray(),$this->opekField));
            }
        }
        return $sum;
    }
    private function getTableData($fact,$plan,$type)
    {
        $oilCondensateConsolidated = new OilCondensateConsolidated();
        $tableData = array();
        if ($type === 'oilCondensateProduction' || $type === 'oilCondensateDelivery') {
            $tableData = $oilCondensateConsolidated->getDataByConsolidatedCategory($fact,$plan,$this->periodRange,$type);
        }
        return $tableData;
    }
}

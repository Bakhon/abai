<?php

namespace App\Http\Controllers\VisCenter\ProductionParams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use App\Models\DzoPlan;
use App\Traits\VisualCenter\OilCondensateConsolidated;
use Carbon\Carbon;

class VisualCenterController extends Controller
{
    use OilCondensateConsolidated;
    private $periodStart = '';
    private $periodEnd = '';
    private $periodRange = 0;
    private $historicalPeriodStart = '';
    private $historicalPeriodEnd = '';
    private $dzoName = '';
    private $category = '';
    private $filter = '';
    private $planFields = array('dzo');
    private $factFields = array('dzo_name');
    private $chartData = array();
    private $tableData = array();
    private $factField = '';
    private $planField = '';
    private $opekField = '';
    private $factCondensateField = '';
    private $planCondensateField = '';
    private $isOpek = false;
    private $categoryMapping = array (
        'oilCondensateProduction' => array (
            'oilProductionMapping',
            'oilDeliveryMapping',
            'condensateProductionMapping'
        )
    );
    //oil
    private $oilProductionMapping = array (
        'factField' => 'oil_production_fact',
        'planField' => 'plan_oil',
        'opekField' => 'plan_oil_opek',
    );
    private $oilDeliveryMapping = array (
        'factField' => 'oil_delivery_fact',
        'planField' => 'plan_oil_dlv',
        'opekField' => 'plan_oil_dlv_opek',
    );
    //condensate
    private $condensateProductionMapping = array (
        'factField' => 'condensate_production_fact',
        'planField' => 'plan_kondensat',
    );
    private $condensateDeliveryMapping = array (
        'factField' => 'condensate_delivery_fact',
        'planField' => 'plan_kondensat_dlv',
    );
    //stock of goods
    private $goodStockMapping = array (
        'factField' => 'stock_of_goods_delivery_fact'
    );
    //natural gas
    private $naturalGasMapping = array (
        'factField' => 'natural_gas_production_fact',
        'planField' => 'plan_prirod_gas',
    );
    private $naturalGasDeliveryMapping = array (
        'factField' => 'natural_gas_delivery_fact',
        'planField' => 'plan_prirod_gas_dlv',
    );
    private $naturalGasExpensesMapping = array (
        'factField' => 'natural_gas_expenses_for_own_fact',
        'planField' => 'plan_prirod_gas_raskhod',
    );
    //associated gas
    private $associatedGasMapping = array (
        'factField' => 'associated_gas_production_fact',
        'planField' => 'plan_poput_gas',
    );
    private $associatedFlaringGasMapping = array (
        'factField' => 'associated_gas_flaring_fact',
        'planField' => 'plan_poput_gas_burn',
    );

    private $associatedGasDeliveryMapping = array (
        'factField' => 'associated_gas_delivery_fact',
        'planField' => 'plan_poput_gas_dlv',
    );
    private $associatedGasExpensesMapping = array (
        'factField' => 'associated_gas_expenses_for_own_fact',
        'planField' => 'plan_poput_gas_raskhod',
    );
    //water
    private $seaWaterInjectionMapping = array (
        'factField' => 'agent_upload_seawater_injection_fact',
        'planField' => 'plan_liq_ocean',
    );
    private $wasteWaterInjectionMapping = array (
        'factField' => 'agent_upload_waste_water_injection_fact',
        'planField' => 'plan_liq_waste',
    );
    private $artezianWaterInjectionMapping = array (
        'factField' => 'agent_upload_albsenomanian_water_injection_fact',
        'planField' => 'plan_liq_albsen',
    );

    public function getProductionParamsByCategory(Request $request)
    {
        $this->refreshRequestParams($request->request);
        $this->refreshFields();
        $currentPeriodDzoFact = $this->getDzoFact($this->periodStart,$this->periodEnd);
        $currentPeriodDzoPlan = $this->getDzoPlan($this->periodStart,$this->periodEnd);
        $historicalDzoFact = $this->getDzoFact($this->historicalPeriodStart,$this->historicalPeriodEnd);
        $historicalDzoPlan = $this->getDzoPlan($this->historicalPeriodStart,$this->historicalPeriodEnd);
        if ($this->periodRange > 0) {
            $this->chartData = $this->getChartData($currentPeriodDzoFact,$currentPeriodDzoPlan);
        }
        $this->tableData = $this->getTableData($currentPeriodDzoFact,$currentPeriodDzoPlan);
        dd($this->tableData);
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
    }

    private function refreshFields()
    {
        $categories = $this->categoryMapping[$this->category];
        foreach($categories as $fields) {
            array_push($this->planFields, $this->$fields['planField']);
            if (isset($this->$fields['opekField'])) {
                array_push($this->planFields, $this->$fields['opekField']);
            }
            array_push($this->factFields, $this->$fields['factField']);
        }

        $selectedCategory = $categories[0];
        $this->factField = $this->$selectedCategory['factField'];
        $this->planField = $this->$selectedCategory['planField'];
        $this->isOpek = $this->category === 'oilCondensateProduction' || $this->category === 'oilCondensateDelivery';
        if ($this->isOpek) {
            $condensateCategory = $this->categoryMapping[$this->category][2];
            $this->opekField = $this->$selectedCategory['opekField'];
            $this->factCondensateField = $this->$condensateCategory['factField'];
            $this->planCondensateField = $this->$condensateCategory['planField'];
        }
    }

    private function getDzoFact($startDate,$endDate)
    {
        $query = DzoImportData::query()
             ->select($this->factFields)
             ->addSelect(DB::raw('DATE_FORMAT(date,"%d.%m.%Y") as date'))
             ->whereDate('date', '>=', $startDate)
             ->whereDate('date', '<=', $endDate)
             ->whereNull('is_corrected');
        if (!is_null($this->dzoName)) {
            $query->where('dzo_name', $this->dzoName);
        }
        return $query->orderBy('date', 'asc')->with('importDowntimeReason')->get();
    }
    private function getDzoPlan($startDate,$endDate)
    {
        $query = DzoPlan::query()
            ->select($this->planFields)
            ->addSelect(DB::raw('DATE_FORMAT(date,"%d.%m.%Y") as dates'))
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
    private function getTableData($fact,$plan)
    {
        $tableData = '';
        if ($this->category === 'oilCondensateProduction' || $this->category === 'oilCondensateDelivery') {
            $tableData = $this->getDataByConsolidatedCategory($fact,$plan);
        }
        return $tableData;
    }
}

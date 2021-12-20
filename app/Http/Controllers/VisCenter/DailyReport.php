<?php

namespace App\Http\Controllers\VisCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\VisualCenterDailyReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDecreaseReason;
use App\Models\VisCenter\ExcelForm\DzoPlan;
use App\Models\VisCenter\ImportForms\DZOyear;

class DailyReport extends Controller
{
    private $dailyParams = array();
    private $monthlyParams = array();
    private $monthlyReasons = array();
    private $yearlyParams = array();
    private $yearlyReasons = array();
    private $yearlyPlans = array();
    private $periodMapping = array(
        'day' => 'dailyParams',
        'month' => 'monthlyParams',
        'year' => 'yearlyParams'
    );
    private $skippingDzo = array ('ПККР','КГМКМГ','ТП');
    private $dzoMapping = array (
        'ТШО' => array (
            'id' => 1,
            'sortId' => 1,
            'name' => 'ТОО "Тенгизшевройл"',
            'part' => 20
        ),
        'ОМГ' => array (
            'id' => 2,
            'sortId' => 2,
            'name' => 'АО "Озенмунайгаз" (нефть)',
            'part' => 100
        ),
        'ОМГК' => array (
            'id' => '',
            'sortId' => 3,
            'name' => '(конденсат)',
            'part' => null
        ),
        'ММГ' => array (
            'id' => 3,
            'sortId' => 4,
            'name' => 'АО "Мангистаумунайгаз"',
            'part' => 50
        ),
        'ЭМГ' => array (
            'id' => 4,
            'sortId' => 5,
            'name' => 'АО "Эмбамунайгаз"',
            'part' => 100
        ),
        'НКО' => array (
            'id' => 5,
            'sortId' => 6,
            'name' => '"Норт Каспиан Оперейтинг Компани н.в."',
            'part' => 8,44
        ),
        'КПО' => array (
            'id' => 6,
            'sortId' => 7,
            'name' => '"Карачаганак Петролеум Оперейтинг б.в."',
            'part' => 10
        ),
        'КБМ' => array (
            'id' => 7,
            'sortId' => 8,
            'name' => 'АО "Каражанбасмунай"',
            'part' => 50
        ),
        'КГМ' => array (
            'id' => 8,
            'sortId' => 9,
            'name' => 'ТОО "СП "Казгермунай"',
            'part' => 50
        ),
        'ПКИ' => array (
            'id' => 9,
            'sortId' => 10,
            'name' => 'АО "ПетроКазахстан Инк"',
            'part' => 33
        ),
        'КТМ' => array (
            'id' => 10,
            'sortId' => 11,
            'name' => 'ТОО "Казахтуркмунай"',
            'part' => 100
        ),
        'КОА' => array (
            'id' => 11,
            'sortId' => 12,
            'name' => 'ТОО "Казахойл Актобе"',
            'part' => 50
        ),
        'УО' => array (
            'id' => 12,
            'sortId' => 13,
            'name' => 'ТОО "Урихтау Оперейтинг"',
            'part' => 100
        ),
        'АГ' => array (
            'id' => 13,
            'sortId' => 14,
            'name' => 'ТОО "Амангельды Газ" (конденсат)',
            'part' => 100
        ),
    );

    protected $monthlyDecreaseReasonFields = array (
        'monthly_reason_1_explanation' => 'monthly_reason_1_losses',
        'monthly_reason_2_explanation' => 'monthly_reason_2_losses',
        'monthly_reason_3_explanation' => 'monthly_reason_3_losses',
        'monthly_reason_4_explanation' => 'monthly_reason_4_losses',
        'monthly_reason_5_explanation' => 'monthly_reason_5_losses',
    );
    protected $yearlyDecreaseReasonFields = array (
        'yearly_reason_1_explanation' => 'yearly_reason_1_losses',
        'yearly_reason_2_explanation' => 'yearly_reason_2_losses',
        'yearly_reason_3_explanation' => 'yearly_reason_3_losses',
        'yearly_reason_4_explanation' => 'yearly_reason_4_losses',
        'yearly_reason_5_explanation' => 'yearly_reason_5_losses',
    );

    public function getDailyProduction(Request $request)
    {
        $date = Carbon::parse($request->date);
        $daily = $this->getDailyParams($date);
        $monthly = $this->getMonthlyParams($date);
        $yearly = $this->getYearlyParams($date);
        $this->processDzoByPeriod($daily,$this->periodMapping['day'],$request);
        $this->processDzoByPeriod($monthly,$this->periodMapping['month'],$request);
        $this->processDzoByPeriod($yearly,$this->periodMapping['year'],$request);

        return [
            'daily' => $this->dailyParams,
            'monthly' => $this->monthlyParams,
            'yearly' => $this->yearlyParams
        ];
    }

    private function getDailyParams($date)
    {
        return array (
            'periodStart' => $date->copy()->startOf('day')->format('Y-m-d'),
            'periodEnd' => $date->copy()->endOf('day')->format('Y-m-d'),
            'historicalPeriodStart' => $date->copy()->sub(1,'days')->startOf('day')->format('Y-m-d'),
            'historicalPeriodEnd' => $date->copy()->sub(1,'days')->endOf('day')->format('Y-m-d'),
            'periodRange' => 0,
            'category' => 'oilCondensateProduction',
            'periodType' => 'day'
        );
    }

    private function getMonthlyParams($date)
    {
        $monthlyDate = $date->copy();
        if (Carbon::now()->day < 3) {
            $monthlyDate = $monthlyDate->sub(3,'days');
        }
        $monthlyEndPeriod = $monthlyDate->copy()->endOf('day');
        $monthStart =  $monthlyDate->copy()->startOf('month');
        $monthlyDiff = $monthStart->diff($monthlyEndPeriod)->days;

        $this->monthlyReasons = $this->getReasonsByPeriod($monthStart,$monthlyEndPeriod,$this->monthlyDecreaseReasonFields);
        return array (
            'periodStart' => $monthStart->format('Y-m-d'),
            'periodEnd' => $monthlyEndPeriod->format('Y-m-d'),
            'historicalPeriodStart' => $monthStart->copy()->sub($monthlyDiff,'days')->format('Y-m-d'),
            'historicalPeriodEnd' => $monthlyDate->copy()->sub(1,'days')->format('Y-m-d'),
            'periodRange' => $monthlyDiff,
            'category' => 'oilCondensateProduction',
            'periodType' => 'month'
        );
    }

    private function getYearlyParams($date)
    {
        $yearEnd = Carbon::now()->sub(1,'month')->endOf('month')->endOf('day');
        $yearStart = $date->copy()->startOf('year');
        $yearlyDiff = $yearStart->diff($yearEnd)->days;

        $this->yearlyPlans = $this->getYearPlan();
        $this->yearlyReasons = $this->getReasonsByPeriod($yearStart,$yearEnd,$this->yearlyDecreaseReasonFields);
        return array (
            'periodStart' => $yearStart->format('Y-m-d'),
            'periodEnd' => $yearEnd->format('Y-m-d'),
            'historicalPeriodStart' => $yearStart->copy()->sub($yearlyDiff,'days')->format('Y-m-d'),
            'historicalPeriodEnd' => $date->copy()->sub(1,'days')->format('Y-m-d'),
            'periodRange' => $yearlyDiff,
            'category' => 'oilCondensateProduction',
            'periodType' => 'year'
        );
    }

    private function getReasonsByPeriod($start,$end,$fields)
    {
        $productionParams = DzoImportData::query()
            ->select(['id','dzo_name'])
            ->whereDate('date', '>=', $start)
            ->whereDate('date', '<=', $end)
            ->whereNull('is_corrected')
            ->with('importDecreaseReason')
            ->get();

        $formatted = array();
        foreach($productionParams as $day) {
            if (!array_key_exists($day['dzo_name'],$formatted)) {
                $formatted[$day['dzo_name']] = array();
            }
            if (is_null($day['importDecreaseReason'])) {
                continue;
            }
            foreach($fields as $key => $value) {
                if (!is_null($day['importDecreaseReason'][$key])) {
                    $formatted[$day['dzo_name']][$key] = array(
                        $day['importDecreaseReason'][$key],
                        $day['importDecreaseReason'][$value]
                    );
                }
            }
            //foreach($fields as $key => $value) {
            //    if (!is_null($day['importDecreaseReason'][$key]) && !$this->isAlreadyExist($formatted[$day['dzo_name']],$day['importDecreaseReason'][$value])) {
             //       array_push($formatted[$day['dzo_name']],array($day['importDecreaseReason'][$key],$day['importDecreaseReason'][$value]));
            //    }
           // }
        }
        return $formatted;
    }

    private function getYearPlan()
    {
        $plans = DZOyear::query()
            ->select(['dzo','oil_plan','gk_plan'])
            ->where('date', Carbon::now()->year)
            ->get();

        $formatted = array();
        foreach($plans as $year) {
            $formatted[$year['dzo']] = $year['oil_plan'];
            if ($year['dzo'] === 'ОМГ') {
                $formatted['ОМГК'] = $year['gk_plan'];
            }
            if ($year['dzo'] === 'АГ') {
                $formatted[$year['dzo']] = $year['gk_plan'];
            }
            $dzoList = array_keys($this->dzoMapping);
            if (!in_array($year['dzo'],$dzoList)) {
                continue;
            }

            $multiplier = $this->dzoMapping[$year['dzo']]['part'];
            if (is_null($multiplier)) {
                $multiplier = 100;
            }
            $formatted[$year['dzo']] = $formatted[$year['dzo']] / 100 * $multiplier;
        }
        return $formatted;
    }

    private function isAlreadyExist($dzoReasons,$name)
    {
        foreach($dzoReasons as $reason) {
            if (in_array($name, $reason)) {
                return true;
            }
        }
        return false;
    }

    private function processDzoByPeriod($params,$type,$request)
    {
        $request->replace($params);
        $allDailyCategories = app()->call('App\Http\Controllers\VisCenter\ProductionParams\VisualCenterController@getProductionParamsByCategory',$params);
        $daily = $allDailyCategories['tableData']['current']['oilCondensateProduction'];

        foreach($daily as  $dzo) {
            if (!in_array($dzo['name'],$this->skippingDzo)) {
                $dzoDetails = array (
                    'id' => $this->dzoMapping[$dzo['name']]['id'],
                    'orderId' => $this->dzoMapping[$dzo['name']]['sortId'],
                    'name' => $this->dzoMapping[$dzo['name']]['name'],
                    'part' => $this->dzoMapping[$dzo['name']]['part'],
                    'plan' => $dzo['plan'],
                    'fact' => $dzo['fact'],
                    'reasons' => array(),
                );
                if ($dzo['name'] !== 'ОМГК') {
                    $dzoDetails['reasons'] = $dzo['decreaseReasonExplanations'];
                }
                if ($params['periodType'] === 'month') {
                    $dzoDetails['monthlyPlan'] = $dzo['monthlyPlan'];
                }
                if ($params['periodType'] === 'year') {
                    $dzoDetails['yearlyPlan'] = $this->yearlyPlans[$dzo['name']];
                }
                if ($params['periodType'] === 'month' && $dzo['name'] !== 'ОМГК') {
                    $dzoDetails['reasons'] = $this->monthlyReasons[$dzo['name']];
                }
                if ($params['periodType'] === 'year' && $dzo['name'] !== 'ОМГК') {
                    $dzoDetails['reasons'] = $this->yearlyReasons[$dzo['name']];
                }
                array_push($this->$type,$dzoDetails);
            }
        }

        $sortOrder = array_column($this->$type, 'orderId');
        array_multisort($sortOrder, SORT_ASC, $this->$type);
    }
}
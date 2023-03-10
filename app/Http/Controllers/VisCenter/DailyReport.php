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
use Illuminate\Support\Facades\Cache;

class DailyReport extends Controller
{
    private $dailyParams = array();
    private $monthlyParams = array();
    private $monthlyReasons = array(
        'КГМ' => [],
        'ПКК' => [],
        'УО' => [],
        'ЭМГ' => [],
        'ОМГ' => [],
        'ММГ' => [],
        'КОА' => [],
        'КБМ' => [],
        'АГ' => [],
        'ТШО' => [],
        'ТП' => [],
        'КПО' => [],
        'ПКИ' => [],
        'НКО' => [],
        'КТМ' => []
    );
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
            'part' => 8.44
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
    private $summary = array (
        'daily' => array(),
        'monthly' => array(),
        'yearly' => array()
    );
    private $saveTime = 1440;
    private $nkoFormula = ((1 - 0.019) * 241 / 1428) / 2;
    private $missedCompanies = [];

    public function getDailyProduction(Request $request)
    {
        $name = 'daily_report_excel_' . Carbon::now()->format('M_d_Y');
        if (Cache::has($name)) {
            return Cache::get($name);
        }
        $date = Carbon::parse($request->date);
        $daily = $this->getDailyParams($date);
        $monthly = $this->getMonthlyParams($date);
        $yearly = $this->getYearlyParams($date);
        $this->processDzoByPeriod($daily,$this->periodMapping['day'],$request);
        $this->processDzoByPeriod($monthly,$this->periodMapping['month'],$request);
        $this->processDzoByPeriod($yearly,$this->periodMapping['year'],$request);
        $this->fillSummary();
        $productionByPeriods = [
            'daily' => $this->dailyParams,
            'monthly' => $this->monthlyParams,
            'yearly' => $this->yearlyParams,
            'summary' => $this->summary,
            'missing' => array_values($this->missedCompanies)
        ];
        Cache::put($name, $productionByPeriods, $this->saveTime);
        return $productionByPeriods;
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

        $reasons = $this->getReasonsByPeriod($this->monthlyDecreaseReasonFields,Carbon::yesterday(),'whereDate');
        $diff = array_diff(array_keys($this->monthlyReasons),array_keys($reasons));
        if (count($diff) > 0) {
            $this->missedCompanies = $diff;
            foreach($diff as $dzo) {
                $reasons[$dzo] = [];
            }
        }
        $this->monthlyReasons = $reasons;

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
        $reasons = $this->getReasonsByPeriod($this->yearlyDecreaseReasonFields,Carbon::yesterday()->subMonth(),'whereMonth');
        $diff = array_diff(array_keys($this->monthlyReasons),array_keys($reasons));
        if (count($diff) > 0) {
            foreach($diff as $dzo) {
                $reasons[$dzo] = [];
            }
        }
        $this->yearlyReasons = $reasons;

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

    private function getReasonsByPeriod($fields,$date,$query)
    {
        $productionParams = DzoImportData::query()
            ->select(['id','dzo_name'])
            ->$query('date',$date)
            ->whereNull('is_corrected')
            ->orderBy('date', 'asc')
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
                    $multiplier = $this->dzoMapping[$day['dzo_name']]['part'];
                    $formatted[$day['dzo_name']][$key] = array(
                        $day['importDecreaseReason'][$key],
                        $day['importDecreaseReason'][$value] * $multiplier / 100
                    );
                }
            }
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
            if ($year['dzo'] === 'НКО') {
                $formatted[$year['dzo']] = $formatted[$year['dzo']] * $this->nkoFormula;
            } else {
                $formatted[$year['dzo']] = $formatted[$year['dzo']] / 100 * $multiplier;
            }
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
                    'acronym' => $dzo['name']
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
                if ($dzo['name'] === 'НКО') {
                    $dzoDetails['part'] = str_replace('.', ',', $dzoDetails['part']);
                }
                array_push($this->$type,$dzoDetails);
            }
        }

        $sortOrder = array_column($this->$type, 'orderId');
        array_multisort($sortOrder, SORT_ASC, $this->$type);
    }

    private function fillSummary()
    {
        $this->summary['daily']['fact'] = array_sum(array_column( $this->dailyParams, 'fact'));
        $this->summary['daily']['plan'] = array_sum(array_column( $this->dailyParams, 'plan'));
        $this->summary['monthly']['fact'] = array_sum(array_column( $this->monthlyParams, 'fact'));
        $this->summary['monthly']['plan'] = array_sum(array_column( $this->monthlyParams, 'plan'));
        $this->summary['monthly']['monthlyPlan'] = array_sum(array_column( $this->monthlyParams, 'monthlyPlan'));
        $this->summary['yearly']['fact'] = array_sum(array_column( $this->yearlyParams, 'fact'));
        $this->summary['yearly']['plan'] = array_sum(array_column( $this->yearlyParams, 'plan'));
        $this->summary['yearly']['yearlyPlan'] = array_sum(array_column( $this->yearlyParams, 'yearlyPlan'));
    }
}
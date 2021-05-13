<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Http\Controllers\Controller;
use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;
use App\Models\EcoRefsAvgMarketPrice;
use App\Models\EcoRefsAvgPrs;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsDiscontCoefBar;
use App\Models\EcoRefsEquipId;
use App\Models\EcoRefsMacro;
use App\Models\EcoRefsNdoRates;
use App\Models\EcoRefsPrepElectPrsBrigCost;
use App\Models\EcoRefsProcDob;
use App\Models\EcoRefsRentEquipElectServCost;
use App\Models\EcoRefsRentTax;
use App\Models\EcoRefsRoutesId;
use App\Models\EcoRefsServiceTime;
use App\Models\EcoRefsTarifyTn;
use App\Models\Refs\EcoRefsEmpPer;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;
use function Complex\ln;

class FieldCalcController extends MainController
{
    const  ONE_YEAR = 365;
    const  SERVICE_TIME = 12;
    public $razrab = 5;
    public $prs = null;
    public $year = null;
    public $qZhidkosti = null;
    public $qoil = null;
    public $reqDay = null;
    public $reqecn = null;
    public $param = null;
    public $liq = null;
    public $company = null;
    public $insideMarketDirections = null;
    public $equipIdRequest = null;
    public $fluidProduction = null;
    public $prsCostResults = [];
    public $scorfa = null;
    public $companyId = null;
    public $exportDirections = [];

    public $opiuHandbook = [];

    public $opiuNames = [
        'B61000000000', 'B62000000000', 'BZ7001030000', 'BZ7001120000', 'B71190010000',
        'BZ7001180000', 'BZ7001240000', 'BZ7001260000', 'B72165030000', 'B72190080000',
        'BZ7001340000', 'B71136000000', 'B71138000000', 'B72140000000', 'B72145000000',
        'BZ7001470000', 'BZ7001500000', 'B72155000000', 'BZ7001600000', 'BZ7001620000',
        'BZ7001670000', 'BZ7001700000', 'BZ7001800000', 'BZ7001840000', 'BZ7001850000',
        'B72186000000', 'BZ7001880000', 'BZ7001900500',
    ]; // Данные на отображение

    public $opiuOilNames = [
        'BZ7001050000',
        'BZ7001010000',
    ];

    public $opiuLiqiudNames = [
        'B72190070000',
        'B71107000000',
        'B71111000000',
        'B71112000000',
        'B71118000000',
        'B71140000000',
        'B71150000000',
        'B71170000000',
        'B71180000000',
        'B72186000000',
        'B72192000000',
        'B71197000000',
        'B72197000002',
        'B74800000000',
        'B72112000000',
        'B73000000000',
        'B74000000000',
    ];

    public function __construct()
    {
        $this->routes = EcoRefsRoutesId::pluck('id', 'name')->toArray(); // все маршруты
        $this->scenarios = EcoRefsScFa::pluck('id', 'name')->toArray(); // сценарии/факт
        $this->exportDirections = EcoRefsDirectionId::where('name', '=', 'Экспорт')->pluck('id', 'name'); // все направления
        $this->insideMarketDirections = EcoRefsDirectionId::where('name', '=', 'Внутренний рынок')->pluck('id', 'name'); // все направления
        $this->opiuHandbook = HandbookRepTt::pluck('name', 'num');
    }

    public function index(Request $request)
    {
        $companies = SubholdingCompany::where('parent_id','!=', 0)->get();
        $scenarioFact = 3;
        if(isset($request->scenario)){
            $scenarioFact = $request->scenario;
        }
        $this->year = $request->date ?? '2021';
        $this->fluidProduction = 91.3;
        $this->qoil = $request->oil;
        $this->reqDay = 365;
        $this->reqecn = $request->reqecn;
        $this->param = $request->param;
        $this->liq = $request->liq;
        $this->companyId = $request->company;// id компании
        $this->equipIdRequest = $request->equip; // id оборудования
        $typesOfEquipment = EcoRefsEquipId::pluck('id'); // id виды оборудования
        $company = EcoRefsCompaniesId::find($this->companyId)->first();
        $godovoiLiquid = null;
        $godovoiOil = null;
        $godovoiEmpper = null;
        $godovoiWorkday = null;
        $godovoiNdo = null;
        $godovoiDohod = null;
        $godovoiNdnpi = null;
        $godovoiRent = null;
        $godovoiEtp = null;
        $godovoiTrans = null;
        $godovoiZatrElectrShgn = null;
        $godovoiZatrElectrEcn = null;
        $godovoiZatrPrep = null;
        $godovoiZatrPrs = null;
        $godovoiZatrSutObs = null;
        $godovoiArenda = null;
        $godovoiAmortizacia = null;
        $godovoiOperPryb = null;
        $godovoiKpn = null;
        $godovoiChistPryb = null;
        $godovoiKvl = null;
        $godovoiSvobPot = null;
        $godovoiShgnParam = null;
        $godovoiEcnParam = null;
        $nakoplSvobPotok = null;
        $discSvobPotok = null;
        $nakopDiscSvodPotok = null;
        $npv = null;
        $data = [];

        $totalWells = 3421; // Средний действующий фонд, скв (Всего)
        $activeWells = [
            1 => '3',
            3 => '4',
        ]; // Средний действующий фонд, скв по маршрутам (route_id => count)

        $opiuValues = SubholdingCompany::whereName($company->name)->first();
        if ($opiuValues) {
            $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
            $companyRepTtValues = $opiuValues->statsByDate($this->year)->get()->toArray();
            $opiuValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $this->year, $this->year - 1, $this->year . '-01-01', $this->year . '-12-01');
        }
        FieldCalcHelper::sumOverTree($opiuValues, $this->year); // суммирование по дереву


        $result = [];
        $this->getShowDataOnTree($this->opiuNames, $opiuValues, $result);
        $opiuTree = [];
        foreach($activeWells as $routeId => $activeWell){
            foreach($result as $opiu){
                $opiuTree[$this->getRoute($routeId)][$opiu['name']] = $opiu['value']/$totalWells*$activeWell;
            }
        }

        $data[$this->year]['opiu'] = $opiuTree;

        for ($month = 1; $month <= 12; $month++) {
            $exportsResults = [];
            $exportsDiscontResults = [];
            $exportsNdpiResults = [];
            $exportsRentTaxResults = [];
            $exportsEtpResults = [];
            $exportsTarTnResults = [];
            $zatrPrepResults = [];
            $zatrElectResults = [];
            $expDayResults = [];

            if ($month > 9){
                $monthname = $month;
            } else {
                $monthname = '0' . $month;
            }
            $lastDateOfMonth = date("Y-m-t", strtotime($this->year . '-' . $monthname . '-01'));
            $firstDateOfMonth = date("Y-m-d", strtotime($this->year . '-' . $monthname . '-01'));
            $lastDay = date("d", strtotime($lastDateOfMonth));
            $rate = EcoRefsMacro::where('date', '=', $firstDateOfMonth)->first(); // Курс доллара/Курс рубля/Инфляция, в % на конец периода/Стоимость барреля нефти
            $emppersExp = EcoRefsEmpPer::whereIn('direction_id', $this->exportDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->get(); // процент реализации
            $discontExp = EcoRefsDiscontCoefBar::whereIn('direction_id', $this->exportDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->get(); // Коэффициент баррелизации, Дисконт, Стоимость нефти
            $electricityCosts = EcoRefsPrepElectPrsBrigCost::where('company_id', $this->companyId)->where('sc_fa', $scenarioFact)->where('date', $firstDateOfMonth)->get(); // Стоимость транспортировки и подготовки, Стоимость 1 сутки бригады, Стоимость электроэнергии,
            $equipmentCosts = EcoRefsRentEquipElectServCost::whereIn('equip_id', $typesOfEquipment)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->whereYear('date', $this->year)->get(); //  Стоимость оборудования/Стоимость аренды/Расход электроэнергии/Стоимость суточного обслуживания

            $prsResult = [];
            foreach ($electricityCosts as $cost) {
                $avgprsday = EcoRefsAvgPrs::where('company_id', $cost->company_id)->where('date', $firstDateOfMonth)->first();
                if ($avgprsday) {
                    $avgprsday = $avgprsday->avg_prs;
                }
                if ($this->param == 1 && $this->reqDay >= self::ONE_YEAR) {
                    $prsResult[$cost->company_id] = self::ONE_YEAR / ($this->reqDay);
                } elseif ($this->param == 2 && $this->equipIdRequest != 1) {
                    $prsResult[$cost->company_id] = $this->reqecn;
                } else {
                    $prsResult[$cost->company_id] = self::ONE_YEAR / ($this->reqDay + $avgprsday);
                }
            } // Количество ПРС

            $avgprsday = EcoRefsAvgPrs::where('company_id', $this->companyId)->first();
            if ($avgprsday) {
                $avgprsday = $avgprsday->avg_prs; // Средняя продолжительность 1 ПРС, сут
            }

            $workday = $lastDay * ((self::ONE_YEAR - array_sum($prsResult) * $avgprsday) / self::ONE_YEAR); // Количество отработанных дней
            $this->liquid = $this->fluidProduction * $workday; // Доп. добыча жидкости, тыс.т
            $oil = $this->qoil * (1 - exp(log(1 - $this->razrab / 100) / self::ONE_YEAR * $workday)) / -(log(1 - $this->razrab / 100) / self::ONE_YEAR); // добыча нефти всего ?

            $percentRealization = EcoRefsProcDob::where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->first(); // Процент от добычи на реализацию
            if ($percentRealization) {
                $percentRealization = $percentRealization->proc_dob;
            }
            $empper = $oil - $oil * $percentRealization;

            $ecnParam = 95.343 * pow($this->liq, -0.607);
            $shgnParam = 108.29 * pow($this->liq, -0.743);

            foreach ($emppersExp as $item) {
                $exportsResults[$item->route_id] = $empper * $item->emp_per; // Объем реализации нефти по маршрутам
            }
            $exportsResultsTotal = array_sum($exportsResults); //Объем реализации нефти на экспорт, всего

            foreach ($electricityCosts as $item) {
                $zatrPrepResults = $this->liquid * $item->trans_prep_cost;
            }

            $electCost = EcoRefsPrepElectPrsBrigCost::where('company_id', '=', $item->company_id)->first(); // тут надо исправить
            foreach ($equipmentCosts as $item) {
                if ($item->equip_id == 1) {  // тип оборудования
                    $zatrElectResults[$item->equip_id] = $workday * $this->liq * $shgnParam * $electCost->elect_cost; // Затраты на электроэнергию
                } else {
                    $zatrElectResults[$item->equip_id] = $workday * $this->liq * $ecnParam * $electCost->elect_cost;//Затраты на электроэнергию
                }
            }

            foreach ($electricityCosts as $item) {
                $this->prsCostResults = array_sum($prsResult) / 12 * $avgprsday * $item->prs_brigade_cost;
            }

            foreach ($equipmentCosts as $item) {
                $expDayResults[$item->equip_id] = $workday * $item->dayli_serv_cost;
            }

            $rentCostResult = 0;

            if ($this->equipIdRequest != 1) {
                $rentCostResult = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->first()->rent_cost; // Стоимость оборудования/Стоимость аренды/Расход электроэнергии/Стоимость суточного обслуживания
            }

            $buyCostResult = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->where('company_id', $this->companyId)->first()->equip_cost; // Стоимость оборудования/Стоимость аренды/Расход электроэнергии/Стоимость суточного обслуживания

            foreach ($exportsResults as $route_id => $oilValume) {
                $tarifTnItemValue = $this->totalTransportationCostYear($route_id, $scenarioFact, $this->companyId, $oilValume, $rate);
                $exportsTarTnResults[$route_id] = $tarifTnItemValue / 12;
            }
            $exportsTarTnResultsTotal = array_sum($exportsTarTnResults);


            foreach ($discontExp as $item) {
                $exportsDiscontResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * (($item->macro - $item->discont) * $rate->ex_rate_dol);
                $exportsDiscontPrice[$item->route_id] = $item->macro - $item->discont; // Цена на экспорт с учетом дисконта
            }
            $exportsDiscontResultsTotal = array_sum($exportsDiscontResults);

            $stavki = EcoRefsNdoRates::where('company_id', '=', $item->company_id)->first(); // Средняя ставка НДПИ по НДО
            foreach ($discontExp as $item) {
                $exportsNdpiResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro  * $rate->ex_rate_dol * $stavki->ndo_rates;
                $exportsNdpiResultsRub = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rate->ex_rate_rub * $stavki->ndo_rates;
                $data[$company->name][$lastDateOfMonth]['НДПИ нефть на экспорт USD'][] = $exportsNdpiResults[$item->route_id];
                $data[$company->name][$lastDateOfMonth]['НДПИ нефть на экспорт RUB'][] = $exportsNdpiResultsRub;
            }
            $exportsNdpiResultsTotal = array_sum($exportsNdpiResults);

            $rent = EcoRefsRentTax::where('world_price_beg', '<', $item->macro)->where('world_price_end', '<=', $item->macro)->first(); // Ставки - Рентный налог
            foreach ($discontExp as $item) {
                $exportsRentTaxResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rent->rate * $rate->ex_rate_dol;
            }
            $exportsRentTaxResultsTotal = array_sum($exportsRentTaxResults);

            foreach ($discontExp as $item) {
                $etpRate = EcoRefsAvgMarketPrice::where('avg_market_price_beg', '>=', $item->macro)->where('avg_market_price_end', '>', $item->macro)->first(); // Ставки - ЭТП (Среднемесячная рыночная цена ($/баррель), от && Среднемесячная рыночная цена ($/баррель), до)
                $exportsEtpResults[$item->route_id] = $this->calculationETP($exportsResults[$item->route_id], $etpRate->exp_cust_duty_rate, $rate->ex_rate_dol); // Расчет ЭТП (экспорт)
            }
            $exportsEtpResultsTotal = array_sum($exportsEtpResults); //Расчет ЭТП (Экспорт) всего
            // Export END

            // Inside BEGIN
            $emppersIns = EcoRefsEmpPer::whereIn('direction_id', $this->insideMarketDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->get(); //Процент реализации
            $discontIns = EcoRefsDiscontCoefBar::whereIn('direction_id', $this->insideMarketDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->get(); //Коэф баррелизации/Дисконт/Стоимость нефти/Макро

            $insideResults = [];
            $insideDiscontResults = [];
            $insideNdpiResults = [];
            $insideTarTnResults = [];

            foreach ($emppersIns as $item) {
                $insideResults[$item->route_id] = $empper * $item->emp_per;
            }
            $insideResultsTotal = array_sum($insideResults);

            foreach ($discontIns as $item) {
                $insideDiscontResults[$item->route_id] = $insideResults[$item->route_id] * $item->macro;
            }
            $insideDiscontResultsTotal = array_sum($insideDiscontResults);

            foreach ($discontIns as $item) {
                $insideNdpiResults[$item->route_id] = $insideResults[$item->route_id] * $item->macro * $stavki->ndo_rates * 0.5;
            }
            $insideNdpiResultsTotal = array_sum($insideNdpiResults);

            foreach ($insideResults as $route_id => $oilValume) {
                $tarifTnItemValue = $this->totalTransportationCostYear($route_id, $scenarioFact, $this->companyId, $oilValume, $rate);
                $insideTarTnResults[$route_id] = $tarifTnItemValue / 12;
            }
            $insideTarTnResultsTotal = array_sum($insideTarTnResults);
            // Inside END

            if ($this->equipIdRequest == 1) {
                $srokSluzhby = EcoRefsServiceTime::where('equip_id', '=', $this->equipIdRequest)->where('company_id', '=', $this->companyId)->first();
                $equipCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->where('company_id', '=', $this->companyId)->first();
                if ($srokSluzhby->avg_serv_life > self::SERVICE_TIME) {
                    $amortizaciyaResult = $equipCost->equip_cost / $srokSluzhby->avg_serv_life;
                } else {
                    $amortizaciyaResult = 0;
                }
            } else {
                $amortizaciyaResult = 0;
            }

            $operPrib = ($exportsDiscontResultsTotal + $insideDiscontResultsTotal) - ($exportsNdpiResultsTotal + $insideNdpiResultsTotal) - $exportsRentTaxResultsTotal - $exportsEtpResultsTotal - ($exportsTarTnResultsTotal + $insideTarTnResultsTotal) - ($zatrElectResults[$this->equipIdRequest] + $zatrPrepResults + $this->prsCostResults + $expDayResults[$this->equipIdRequest] + $rentCostResult + $amortizaciyaResult);

            if ($operPrib > 0) {
                $kpnResult = $operPrib * 0.2;
            } else {
                $kpnResult = 0;
            }

            $chistayaPribyl = $operPrib - $kpnResult;
            $svobodDenPotok = $chistayaPribyl - $buyCostResult + $amortizaciyaResult;
            $godovoiLiquid += $this->liquid;
            $godovoiOil += $oil;
            $godovoiEmpper += $empper;
            $godovoiWorkday += $workday;
            $godovoiNdo = $godovoiNdo + $exportsResultsTotal + $insideResultsTotal;
            $godovoiDohod += $exportsDiscontResultsTotal + $insideDiscontResultsTotal;
            $godovoiNdnpi += $exportsNdpiResultsTotal + $insideNdpiResultsTotal;
            $godovoiRent += $exportsRentTaxResultsTotal;
            $godovoiEtp += $exportsEtpResultsTotal;
            $godovoiTrans += $exportsTarTnResultsTotal + $insideTarTnResultsTotal;
            $godovoiZatrElectrShgn += $zatrElectResults[1];
            $godovoiZatrElectrEcn += $zatrElectResults[2];
            $godovoiZatrPrep += $zatrPrepResults;
            $godovoiZatrPrs += $this->prsCostResults;
            $godovoiZatrSutObs += $expDayResults[1];
            $godovoiArenda += $rentCostResult;
            $godovoiAmortizacia += $amortizaciyaResult;
            $godovoiOperPryb += $operPrib;
            $godovoiKpn += $kpnResult;
            $godovoiChistPryb += $chistayaPribyl;
            $godovoiKvl += $buyCostResult;
            $godovoiSvobPot += $svobodDenPotok;
            $godovoiShgnParam += $shgnParam * $this->liq * $workday;
            $godovoiEcnParam += $ecnParam * $this->liq * $workday;
            $nakoplSvobPotok += $svobodDenPotok;
            $discSvobPotok += $nakoplSvobPotok;
            $nakopDiscSvodPotok += $discSvobPotok;
            $npv += $svobodDenPotok;

            $exportTransportationValue = [];
            foreach ($exportsTarTnResults as $id => $exportsResult) {
                $exportTransportationValue[$this->getRoute($id)] = $exportsResult;
            }

            $insideTransportationValue = [];
            foreach ($insideTarTnResults as $id => $insideValue) {
                $insideTransportationValue[$this->getRoute($id)] = $insideValue;
            }

            $exportProduction = [];
            foreach ($exportsResults as $id => $exportsResult) {
                $exportProduction[$this->getRoute($id)] = $exportsResult;
            }

            $insideMarket = [];
            foreach ($insideResults as $id => $insideResult) {
                $insideMarket[$this->getRoute($id)] = $insideResult;
            }

            $exportNdpiCalculationResult = [];
            foreach ($exportsNdpiResults as $id => $exportNdpi) {
                $exportNdpiCalculationResult[$this->getRoute($id)] = $insideResult;
            }
            $insideNdpiCalculationResult = [];
            foreach ($insideNdpiResults as $id => $insideNdpi) {
                $insideNdpiCalculationResult[$this->getRoute($id)] = $insideResult;
            }

            $discontPrices = [];
            foreach ($exportsDiscontPrice as $id => $price) {
                $discontPrices[$this->getRoute($id)] = $price;
            }


            $data[$company->name][$lastDateOfMonth]  = [
                'Цена на экспорт с учетом дисконта'=> $discontPrices,
                'Доп. добыча нефти, тыс.т' => $oil,
                'Количество отработанных дней' => $workday,
                'Количество ПРС' => array_sum($prsResult) / 12,
                'Среднее продолжительность 1 ПРС' => $avgprsday,
                'Объем реализации нефти на экспорт (Экспорт)' => [
                    'routes' => $exportProduction,
                    'total' => $exportsResultsTotal
                ],
                'Объем реализации нефти на внутренний рынок (Внут. рынок)' => [
                    'routes' => $insideMarket,
                    'total' => $insideResultsTotal
                ],
                'Расходы по погрузке, транспортировке ЭКСПОРТ' => [
                    'routes' => $exportTransportationValue,
                ],
                'Расходы по погрузке, транспортировке ВНУТ.РЫНОК' => [
                    'routes' => $insideTransportationValue
                ],
                'Расчет НДПИ (Экспорт)'=> $exportNdpiCalculationResult,
                'Расчет НДПИ (Внт. рынок)'=> $insideNdpiCalculationResult,
            ];

//                $vdata2 = [
//                    'last' => $lastDateOfMonth,
//                    'day' => $lastDay,
//                    'year' => $this->year,
//                    'monthname' => $monthname,
//                    'liquid' => $this->liquid,
//                    'oil' =>  $oil,
//                    'empper' => $empper,
//                    'workday' => $workday,
//                    'prs' => array_sum($prsResult) / 12,
//                    'srednii' => $avgprsday->avg_prs,
//                    'exportsResultsTotal' => $exportsResultsTotal,
//                    'exportsResults' => $exportsResults,
//                    'insideResultsTotal' => $insideResultsTotal,
//                    'insideResults' => $insideResults,
//                    'exportsDiscontResultsTotal' => $exportsDiscontResultsTotal,
//                    'insideDiscontResultsTotal' => $insideDiscontResultsTotal,
//                    'insideDiscontResults' => $insideDiscontResults,
//                    'exportsNdpiResultsTotal' => $exportsNdpiResultsTotal,
//                    'exportsNdpiResults' => $exportsNdpiResults,
//                    'insideNdpiResultsTotal' => $insideNdpiResultsTotal,
//                    'insideNdpiResults' => $insideNdpiResults,
//                    'exportsRentTaxResultsTotal' => $exportsRentTaxResultsTotal,
//                    'exportsRentTaxResults' => $exportsRentTaxResults,
//                    'exportsEtpResultsTotal' => $exportsEtpResultsTotal,
//                    'exportsElectResults' => $exportsElectResults,
//                    'lexportsTarTnResultsTotal' => $exportsTarTnResultsTotal,
//                    'exportsTarTnResults' => $exportsTarTnResults,
//                    'insideTarTnResultsTotal' => $insideTarTnResultsTotal,
//                    'insideTarTnResults' => $insideTarTnResults,
//                    'zatrElectResults' => $zatrElectResults,
//                    'zatrPrepResults' => $zatrPrepResults,
//                    'prsCostResults' => $this->prsCostResults,
//                    'expDayResults' => $expDayResults,
//                    'rentCostResult' => $rentCostResult,
//                    'amortizaciyaResult' => $amortizaciyaResult,
//                    'operPrib' => $operPrib,
//                    'kpnResult' => $kpnResult,
//                    'chistayaPribyl' => $chistayaPribyl,
//                    'buyCostResult' => $buyCostResult,
//                    'svobodDenPotok' => $svobodDenPotok,
//                    'npv' => $npv,
//                    'shgnParam' => $shgnParam * $this->liq * $workday,
//                    'ecnParam' => $ecnParam * $this->liq * $workday,
//                ];
//                array_push($result, $vdata2);
        }

        $data[$company->name][$this->year] = [
            'Добыча жидкости' => $godovoiLiquid,
            'добыча нефти, тыс.т' => $godovoiOil,
            'Процент реализации' => $godovoiEmpper,
            'Количество отработанных дней' => $godovoiWorkday,
            'Количество ПРС' => $prsResult,
            'Средний ПРС' => $avgprsday,
            'Годовой НДО' => $godovoiNdo,
            'Годовой доход' => $godovoiDohod,
            'Годовой НДПИ' => $godovoiNdnpi,
            'Расчет Рентного налога' => $godovoiRent,
            'Расчет ЭТП' => $godovoiEtp,
            'Расчет Расходов по транспортировке нефти' => $godovoiTrans,
            'Тип насоса ШГН' => $godovoiZatrElectrShgn,
            'Тип насоса УЭЦН' => $godovoiZatrElectrEcn,
            'godovoiZatrPrep' => $godovoiZatrPrep,
            'Затраты на ПРС' => $godovoiZatrPrs,
            'Затраты за суточное обслуживание' => $godovoiZatrSutObs,
            'Стоимость аренды оборудования' => $godovoiArenda,
            'Амортизация' => $godovoiAmortizacia,
            'Операционная прибыль' => $godovoiOperPryb,
            'КПН' => $godovoiKpn,
            'Чистая прибыль' => $godovoiChistPryb,
            'КВЛ' => $godovoiKvl,
            'Свободный денежный поток' => $godovoiSvobPot,
            'npv' => $npv,
            'godovoiShgnParam' => $godovoiShgnParam,
            'godovoiEcnParam' => $godovoiEcnParam,
        ];

        $opiuOilNames = [];
//        $this->getShowDataOnTree($this->opiuOilNames, $opiuValues, $opiuOilNames);
//        foreach ($opiuOilNames as $oilName){
//            $data[$this->year]['opiu'][$oilName['name']] = $oilName['value']/$godovoiOil*$oil;
//        }

        return view('economy_kenzhe.field_calculation.index')->with(compact('companies', 'data'));

        dd($data);
    }

    public function getDirectionName($id)
    {
        return array_search($id, $this->exportDirections);
    }

    public function getRoute($id)
    {
        return array_search($id, $this->routes);
    }

    public function getShowDataOnTree($names, &$values, &$result = [])
    {
        if (is_array($values)) {
            foreach ($values as $value) {
                if (count($value['handbook_items']) > 0) {
                    $result = $this->getShowDataOnTree($names, $value['handbook_items'], $result);
                }
                if (in_array($value['num'], $names)) {
                    $result[] = [
                        'name' => $value['name'],
                        'value' => $value['plan_value'][2021],
                    ];
                }
            }
            return $result;
        }
    }

    public function getOpiuName($num){

    }

    public function calculationETP($realizationNDO, $rate, $dollar){
        return $realizationNDO * $rate * $dollar;
    }

    public function totalTransportationCostYear($route, $scenarioFact, $companyId, $oilValume, $rate){
        $tarifTn = EcoRefsTarifyTn::where('route_id', $route)->where('sc_fa', $scenarioFact)->where('company_id', $companyId)->get();
        $data = 0;
        foreach ($tarifTn as $tarif) {
            if ($tarif->exc_id == 1) { // Валюта
                $data += $oilValume * $tarif->tn_rate;
            } elseif ($tarif->exc_id == 2) { // Валюта
                $data += $oilValume * $tarif->tn_rate * $rate->ex_rate_dol;
            } else {
                $data += $oilValume * $tarif->tn_rate * $rate->ex_rate_rub;
            }
        }

        return $data;

    }

}

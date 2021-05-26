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
use App\Models\EcoRefsExc;
use App\Models\EcoRefsMacro;
use App\Models\EcoRefsNdoRates;
use App\Models\EcoRefsPrepElectPrsBrigCost;
use App\Models\EcoRefsProcDob;
use App\Models\EcoRefsRentEquipElectServCost;
use App\Models\EcoRefsRentTax;
use App\Models\EcoRefsRoutesId;
use App\Models\EcoRefsRouteTnId;
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
    public $year = null;
    public $qoil = null;
    public $fluidProduction = null;
    public $param = null;
    public $liq = null;
    public $insideMarketDirections = null;
    public $equipIdRequest = null;
    public $companyId = null;
    public $exportDirections = [];

    public $opiuHandbook = [];

    public $opiuRaspMestor = ['B60103000000', 'B60104000000', 'B61001000000', 'B61012000000',
         'B61099450000', 'B61099460000', 'B61099470000', 'B61099990000', 'B61099990097',
         'B61099480000', 'B61099490000', 'B61099500000', 'B61099600000', 'B62100000000',
         'B62110010000', 'B62110020000', 'B62110030000', 'B62120000000', 'B62300000000',
         'B62404040000', 'B62404090200', 'B62499000000', 'B62401000000', 'B62403000000',
         'B62500000000', 'B62800000000', 'B63000000000', 'BZ7001010200', 'BZ7001030000',
         'BZ7001040000', 'BZ7001120400', 'BZ7001120100', 'BZ7001120200', 'BZ7001120300',
         'BZ7001180100', 'BZ7001189900', 'BZ7001240000', 'BZ7001260000', 'BZ7001280000',
         'BZ7001300000', 'BZ7001340000', 'BZ7001360000', 'BZ7001380000', 'BZ7001400000',
         'BZ7001450000', 'BZ7001470100', 'BZ7001470200', 'BZ7001470300', 'BZ7001470400',
         'BZ7001479900', 'BZ7001480000', 'BZ7001490000', 'BZ7001500000', 'BZ7001550000',
         'BZ7001560000', 'BZ7001600000', 'BZ7001610000', 'BZ7001620000', 'BZ7001660000',
         'BZ7001670000', 'BZ7001680000', 'BZ7001720100', 'BZ7001720200', 'BZ7001720300',
         'BZ7001720400', 'BZ7001720500', 'BZ7001720600', 'BZ7001720700', 'BZ7001720800',
         'BZ7001720900', 'BZ7001721000', 'BZ7001721100', 'BZ7001721200', 'BZ7001721300',
         'BZ7001721400', 'BZ7001721500', 'BZ7001729900', 'BZ7001840000', 'BZ7001850000',
         'BZ7001860000', 'BZ7001880100', 'BZ7001880200', 'BZ7001880300', 'BZ7001880400',
         'BZ7001889900', 'BZ7001900100', 'BZ7001900300', 'BZ7001900400', 'BZ7001900500',
         'BZ7001900600', 'BZ7001900700', 'BZ7001900800', 'BZ7001900900', 'BZ7001901000',
         'BZ7001901100', 'BZ7001909800', 'BZ7001909901', 'BZ7001909902', 'BZ7001909903',
         'BZ7001909904', 'BZ7001909999', 'BZ7001920000', 'BZ7001930000', 'BZ7001940000',
         'BZ7001960000', 'BZ7001950000', 'BZ7001970000', 'BZ7001970001', 'BZ7001970002',
         'BZ7001980101', 'BZ7001980102', 'BZ7001980000', 'BZ7001980103', 'BZ7001990000',
         'BZ7001870000', 'BZ7001060000', 'BZ7001070000', 'BZ7001080000', 'BZ7101090000',
         'BZ7101100000', 'BZ7101110000', 'BZ7101120000', 'BZ7101130000', 'BZ7001020000',
         'BZ7001021000', 'BZ7001700100', 'BZ7001700201', 'BZ7001700202', 'BZ7001700203',
         'BZ7001700299', 'BZ7001700301', 'BZ7001700399', 'BZ7001700302', 'BZ7001800000',
        'B73000000000'
    ]; // (ДОХОДЫ) расчет по скважинам или расп. местор.

    public $opiuLiquidNames = [
        'BZ7001010100',
        'BZ7001012000',
        'BZ7001013000',
        'BZ7001015000',
        'BZ7001019900',
        'BZ7001050000'
    ]; // Сырье, материалы и полуфабрикаты, Энергия (тепло-, электроэнергия) расчет по жидкости

    public $opiuOilNames = [
        'B71190010000','B71190030000','B71190050000','B71190990000','B71101000000',
        'B71103000000','B71107000000','B71108000000','B71109000000','B71111000000',
        'B71112030000','B71112010000','B71112020000','B71118010000','B71118020000',
        'B71118990000','B71124000000','B71136000000','B71138000000','B71140000000',
        'B71145000000','B71147010000','B71147020000','B71147030000','B71147040000',
        'B71147050000','B71147060000','B71147990000','B71150000000','B71155000000',
        'B71156000000','B71161000000','B71166000000','B71169000000','B71172010000',
        'B71172020000','B71172030000','B71172040000','B71172050000','B71172060000',
        'B71172070000','B71172080000','B71172090000','B71172100000','B71172110000',
        'B71172120000','B71172130000','B71172140000','B71172150000','B71172990000',
        'B71186000000','B71187000000','B71192000000','B71193000000','B71197000000',
        'B71197000001','B71197000002','B71199000000','B71199900000','B71100000097',
        'B71111000100','B71111000200','B71111000300','B71111000400','B71111000500',
        'B71111000600','B71111000700','B71111000800','B71170010000','B71170020100',
        'B71170020200','B71170020201','B71170020202','B71170020300','B71170029900',
        'B71170030100','B71170039900','B71180000000','B72101000000','B72103000000',
        'B72105000000','B72107000000','B72110000000','B72112040000','B72112010000',
        'B72112020000','B72112030000','B72118020000','B72118030000','B72118990000',
        'B72118010000','B72124000000','B72126000000','B72128000000','B72134000000',
        'B72136000000','B72137000000','B72138000000','B72140000000','B72145000000',
        'B72147010000','B72147020000','B72147030000','B72147040000','B72147050000',
        'B72147060000','B72147990000','B72148000000','B72149000000','B72150000000',
        'B72155000000','B72156000000','B72160000000','B72161000000','B72163000000',
        'B72165000000','B72166000000','B72167000000','B72168000000','B72169000000',
        'B72172010000','B72172020000','B72172030000','B72172040000','B72172050000',
        'B72172060000','B72172070000','B72172080000','B72172090000','B72172100000',
        'B72172110000','B72172120000','B72172130000','B72172140000','B72172150000',
        'B72172990000','B72179000000','B72182000000','B72186000000','B72187000000',
        'B72188000000','B72190070000','B72190080000','B72190090000','B72190100000',
        'B72190110000','B72190990100','B72190990200','B72190990300','B72190990400',
        'B72190999900','B72192000000','B72194000000','B72195000000','B72196000000',
        'B72197000000','B72197000001','B72197000002','B72198000000','B72199000000',
        'B72100000097','B72102000000','B72102100000','B72102110000','B72102120000',
        'B74204150000','B72165010000','B72165020000','B72165030000','B72165040000',
        'B72165060000','B72165070000','B72165080000','B62404030000','B72170010000',
        'B72170020100','B72170020200','B72170020201','B72170020202','B72170020203',
        'B72170020300','B72170029900','B72170030100','B72170039900','B72170030200',
        'B72180000000','B74204100000','B73001000000','B73099000000','B74100000000',
        'B74110010000','B74110020000','B74110030000','B74204000097','B74201000000',
        'B74202000000','B74203000000','B74204190000','B74205000000','B74206000000',
        'B74207000000','B74208000000','B74297000000','B74298000000','B74299000000',
        'B74283000000','B74800000000','B74300000000','B74401000000','B74501000000',
        'B75000000000','B91110301100','B91110301200','B91110300000','B77001010000',
        'B77001020000','B77001030000','B77001040000','B77002010000','B77002030000',
        'B77002040000','BZF402010000'
    ]; // РАСХОДЫ ПО РЕАЛИЗАЦИИ ГОТОВОЙ ПРОДУКЦИИ И ОКАЗАНИЯ УСЛУГ расчет по нефти

    public function __construct()
    {
        $this->routes = EcoRefsRoutesId::pluck('id', 'name')->toArray(); // все маршруты
        $this->routesTn = EcoRefsRouteTnId::pluck('id', 'name')->toArray(); // все маршруты
        $this->rates = EcoRefsExc::pluck('id', 'name')->toArray(); // все маршруты
        $this->scenarios = EcoRefsScFa::pluck('id', 'name')->toArray(); // сценарии/факт
        $this->exportDirections = EcoRefsDirectionId::where('name', '=', 'Экспорт')->pluck('id', 'name'); // все направления
        $this->insideMarketDirections = EcoRefsDirectionId::where('name', '=', 'Внутренний рынок')->pluck('id', 'name'); // все направления
        $this->opiuHandbook = HandbookRepTt::pluck('name', 'num');
    }

    public function index(Request $request)
    {
        $companies = SubholdingCompany::where('parent_id','!=', 0)->get();
        $scenarioFact = 3; // id сценария (Корр. 6 на 2021-2025)
        if(isset($request->scenario)){
            $scenarioFact = $request->scenario;
        }

        if(isset($request->rates)){
            $rates = explode(',', $request->rates);
            foreach($rates as $year => $rate){
                $rates['202'.$year+1] = $rate;
                unset($rates[$year]);
            }
        }
        $raspMestor = 3.1;
        $this->year = $request->date ?? '2021';
        $this->fluidProduction = 91.3;
        $this->qoil = 3.697;
        $this->reqDay = 365;
        $this->reqecn = $request->reqecn;
        $this->param = $request->param;
        $this->liq = $this->fluidProduction;
        $this->companyId = $request->company;// id компании
        $this->equipIdRequest = $request->equip ?? 1; // id оборудования
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
        $activeWells = 35; // Средний действующий фонд, скв

        $opiuValues = SubholdingCompany::whereName($company->name)->first(); // компания из справочника по названию

        if ($opiuValues) {
            $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
            $companyRepTtValues = $opiuValues->statsByDate($this->year)->get()->toArray();
            $opiuValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $this->year, $this->year - 1, $this->year . '-01-01', $this->year . '-12-01');
        }
        FieldCalcHelper::sumOverTree($opiuValues, $this->year); // суммирование по дереву к родителю
//        $this->getShowDataOnTree($this->opiuOilNames, $opiuValues, $dt);
//        $this->getShowDataOnTree($this->opiuLiquidNames, $opiuValues, $dt);
//        $this->getShowDataOnTree($this->opiuRaspMestor, $opiuValues, $dt);
//        $datas = $dt;
        
//        foreach($oils as $year => $oil){
        $year = '2021';
        $datat = [];
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
            $lastDateOfMonth = date("Y-m-t", strtotime($year . '-' . $monthname . '-01'));
            $firstDateOfMonth = date("Y-m-d", strtotime($year . '-' . $monthname . '-01'));
            $lastDay = date("d", strtotime($lastDateOfMonth));
            $rate = EcoRefsMacro::where('date', '=', $firstDateOfMonth)->first(); // Курс доллара/Курс рубля/Инфляция, в % на конец периода/Стоимость барреля нефти
            $emppersExp = EcoRefsEmpPer::whereIn('direction_id', $this->exportDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->get(); // процент реализации
            $discontExp = EcoRefsDiscontCoefBar::whereIn('direction_id', $this->exportDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->get(); // Коэффициент баррелизации, Дисконт, Стоимость нефти
            $electricityCosts = EcoRefsPrepElectPrsBrigCost::where('company_id', $this->companyId)->where('sc_fa', $scenarioFact)->where('date', $firstDateOfMonth)->get(); // Стоимость транспортировки и подготовки, Стоимость 1 сутки бригады, Стоимость электроэнергии,
            $equipmentCosts = EcoRefsRentEquipElectServCost::whereIn('equip_id', $typesOfEquipment)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->whereYear('date', $year)->get(); //  Стоимость оборудования/Стоимость аренды/Расход электроэнергии/Стоимость суточного обслуживания

            $prsResult = [];
            foreach ($electricityCosts as $cost) {
                $avgprsday = EcoRefsAvgPrs::where('company_id', $cost->company_id)->where('date', $firstDateOfMonth)->first(); //Средняя продолжительность 1 ПРС, сут:
                if ($avgprsday) {
                    $avgprsday = $avgprsday->avg_prs;
                }
                if ($this->param == 1 && $this->reqDay >= self::ONE_YEAR) {
                    $prsResult[$cost->company_id] = self::ONE_YEAR / ($this->reqDay);
                } else {
                    $prsResult[$cost->company_id] = self::ONE_YEAR / ($this->reqDay + $avgprsday);
                }
            } // Количество ПРС

            $avgprsday = EcoRefsAvgPrs::where('company_id', $this->companyId)->first(); //Средняя продолжительность 1 ПРС, сут:
            if ($avgprsday) {
                $avgprsday = $avgprsday->avg_prs;
            }

            $workday = $lastDay * ((self::ONE_YEAR - array_sum($prsResult) * $avgprsday) / self::ONE_YEAR); // Количество отработанных дней
            $liquid = $this->fluidProduction * $workday; // Доп. добыча жидкости
            $oil = $this->qoil * (1 - exp(log(1 - $this->razrab / 100) / self::ONE_YEAR * $workday)) / -(log(1 - $this->razrab / 100) / self::ONE_YEAR); // добыча нефти

            $percentRealization = EcoRefsProcDob::where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->first(); // Процент от добычи на реализацию

            if ($percentRealization) {
                $percentRealization = $percentRealization->proc_dob;
                $data[$lastDateOfMonth]['Процент от добычи на реализацию'] = $percentRealization;
            }
            $empper = $oil - $oil * $percentRealization; // % от добычи на реализацию
            $data[$lastDateOfMonth]['добычи на реализацию'] = $empper;
            $data[$lastDateOfMonth]['добыча жидкости'] = $liquid;

            $ecnParam = 95.343 * pow($this->liq, -0.607);
            $shgnParam = 108.29 * pow($this->liq, -0.743);

            foreach ($emppersExp as $item) {
                $exportsResults[$item->route_id] = $empper * $item->emp_per; //  добычи на реализацию (Экспорт)
                $data[$lastDateOfMonth]['Процент реализации '.$this->getRoute($item->route_id)] = $item->emp_per; //Процент реализации
                $data[$lastDateOfMonth]['добычи на реализацию (Экспорт) '.$this->getRoute($item->route_id)] = $empper * $item->emp_per; // добычи на реализацию (Экспорт)
            }
            $exportsResultsTotal = array_sum($exportsResults); //Объем реализации нефти на экспорт, всего

            foreach ($electricityCosts as $item) {
                $zatrPrepResults = $liquid * $item->trans_prep_cost;
            }
            foreach ($equipmentCosts as $item) {
                $electCost = EcoRefsPrepElectPrsBrigCost::where('company_id', '=', $item->company_id)->first(); // тут надо исправить
                if ($item->equip_id == 1) {  // тип оборудования
                    $zatrElectResults[$item->equip_id] = $workday * $this->liq * $shgnParam * $electCost->elect_cost; // Затраты на электроэнергию
                } else {
                    $zatrElectResults[$item->equip_id] = $workday * $this->liq * $ecnParam * $electCost->elect_cost;//Затраты на электроэнергию
                }
            }

            foreach ($electricityCosts as $item) {
                $prsCostResults = array_sum($prsResult) / 12 * $avgprsday * $item->prs_brigade_cost;
            }

            foreach ($equipmentCosts as $item) {
                $expDayResults[$item->equip_id] = $workday * $item->dayli_serv_cost;
            }

            $rentCostResult = 0;

            if ($this->equipIdRequest != 1) {
                $rentCostResult = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->first()->rent_cost; // Стоимость оборудования/Стоимость аренды/Расход электроэнергии/Стоимость суточного обслуживания
            }

            $buyCostResult = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->where('company_id', $this->companyId)->first()->equip_cost; // Стоимость оборудования/Стоимость аренды/Расход электроэнергии/Стоимость суточного обслуживания
            $d = [];
            foreach ($exportsResults as $route_id => $oilValume) {
                $tarifTnItemValue = $this->totalTransportationCostYear($route_id, $scenarioFact, $this->companyId, $oilValume, $rate);
                $exportsTarTnResults[$route_id] = $tarifTnItemValue['value'] / 12;
                $data[$lastDateOfMonth]['Транспортировка нефти тг '.$this->getRoute($route_id)] = $tarifTnItemValue['value'] / 12;
                array_push($d, $tarifTnItemValue['tarif']);
            }
//            return view('economy_kenzhe.field_calculation.tarif')->with(compact('d'));
            $exportsTarTnResultsTotal = array_sum($exportsTarTnResults); // Расчет Расходов по транспортировке нефти
            foreach ($discontExp as $item) {
                if(!$item->barr_coef){
                    $item->barr_coef  = 7.23;
                }
                $exportsDiscontResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * (($item->macro - $item->discont) * $rate->ex_rate_dol); // доход от реализации
                $datat[$lastDateOfMonth]['Доход от реализацииs '.$this->getRoute($item->route_id)] = $exportsResults[$item->route_id] .'*'. $item->barr_coef .'*'. (($item->macro .'-'. $item->discont) .'*'. $rate->ex_rate_dol); // доход от реализации
                $data[$lastDateOfMonth]['цена на экспорт '.$this->getRoute($item->route_id)] = $item->macro;
                $datat[$lastDateOfMonth]['Доход от реализации тг '.$this->getRoute($item->route_id)] = $exportsDiscontResults[$item->route_id];
            }
            $exportsDiscontResultsTotal = array_sum($exportsDiscontResults);

            foreach ($discontExp as $item) {
                if(!$item->barr_coef){
                    $item->barr_coef  = 7.23;
                }
                $stavki = EcoRefsNdoRates::where('company_id', '=', $item->company_id)->first(); // Средняя ставка НДПИ по НДО
                $exportsNdpiResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro  * $rate->ex_rate_dol * $stavki->ndo_rates; //НДПИ нефть на экспорт USD
                $data[$lastDateOfMonth]['НДПИ нефть на экспорт '.$this->getRoute($item->route_id) .' KZT'] = $exportsNdpiResults[$item->route_id];
            }
            $exportsNdpiResultsTotal = array_sum($exportsNdpiResults);

            foreach ($discontExp as $item) {
                if(!$item->barr_coef){
                    $item->barr_coef  = 7.23;
                }
                $rent = EcoRefsRentTax::where('world_price_beg', '<', $item->macro)->where('world_price_end', '<=', $item->macro)->first(); // Ставки - Рентный налог
                $exportsRentTaxResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rent->rate * $rate->ex_rate_dol; // Расчет Рентного налога
                $data[$lastDateOfMonth]['Рентный налог тг '.$this->getRoute($item->route_id) . ' %'] = $exportsRentTaxResults[$item->route_id];
            }
            $exportsRentTaxResultsTotal = array_sum($exportsRentTaxResults);

            foreach ($discontExp as $item) {
                $etpRate = EcoRefsAvgMarketPrice::where('avg_market_price_beg', '>=', $item->macro)->where('avg_market_price_end', '>', $item->macro)->first(); // Ставки - ЭТП (Среднемесячная рыночная цена ($/баррель), от && Среднемесячная рыночная цена ($/баррель), до)
                $exportsEtpResults[$item->route_id] = $this->calculationETP($exportsResults[$item->route_id], $etpRate->exp_cust_duty_rate, $rate->ex_rate_dol); // Расчет ЭТП (экспорт)
                $data[$lastDateOfMonth]['ЭТП (экспорт) '.$this->getRoute($item->route_id) . ' KZT'] = $exportsEtpResults[$item->route_id];
            }
            $exportsEtpResultsTotal = array_sum($exportsEtpResults); // Расчет ЭТП (Экспорт) всего
            // Export END

            // Inside BEGIN
            $emppersIns = EcoRefsEmpPer::whereIn('direction_id', $this->insideMarketDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->get(); //Процент реализации
            $discontIns = EcoRefsDiscontCoefBar::whereIn('direction_id', $this->insideMarketDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $firstDateOfMonth)->get(); //Коэф баррелизации/Дисконт/Стоимость нефти/Макро

            $insideResults = [];
            $insideDiscontResults = [];
            $insideNdpiResults = [];
            $insideTarTnResults = [];

            foreach ($emppersIns as $item) {
                $insideResults[$item->route_id] = $empper * $item->emp_per; // Объем реализации нефти по маршрутам (втн. рынок)
                $data[$lastDateOfMonth]['Процент реализации '.$this->getRoute($item->route_id)] = $item->emp_per; //Процент реализации
                $data[$lastDateOfMonth]['добычи на реализацию (втн. рынок) '.$this->getRoute($item->route_id)] = $empper * $item->emp_per; // Объем реализации нефти по маршрутам (втн. рынок)
            }
            $insideResultsTotal = array_sum($insideResults);

            foreach ($discontIns as $item) {
                $insideDiscontResults[$item->route_id] = $insideResults[$item->route_id] * $item->macro; // доход от реализации
                $data[$lastDateOfMonth]['цена на внтр. рынок '.$this->getRoute($item->route_id)] = $item->macro;
                $data[$lastDateOfMonth]['доход от реализации '.$this->getRoute($item->route_id)] = $insideDiscontResults[$item->route_id];
            }
            $insideDiscontResultsTotal = array_sum($insideDiscontResults);

            foreach ($discontIns as $item) {
                $insideNdpiResults[$item->route_id] = $insideResults[$item->route_id] * $item->macro * $stavki->ndo_rates * 0.5;
                $data[$lastDateOfMonth]['НДПИ внтр. рынок '. $this->getRoute($item->route_id) .' KZT'] = $insideNdpiResults[$item->route_id];
            }
            $insideNdpiResultsTotal = array_sum($insideNdpiResults);
            $d = [];
            foreach ($insideResults as $route_id => $oilValume) {
                $tarifTnItemValue = $this->totalTransportationCostYear($route_id, $scenarioFact, $this->companyId, $oilValume, $rate);
                $insideTarTnResults[$route_id] = $tarifTnItemValue['value'] / 12;
                $data[$lastDateOfMonth]['Транспортировка нефти '.$this->getRoute($route_id)] = $insideTarTnResults[$route_id]/ 12;
                array_push($d, $tarifTnItemValue['tarif']);
            }
//            return view('economy_kenzhe.field_calculation.tarif')->with(compact('d'));
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

            $operPrib = ($exportsDiscontResultsTotal + $insideDiscontResultsTotal) - ($exportsNdpiResultsTotal + $insideNdpiResultsTotal) - $exportsRentTaxResultsTotal - $exportsEtpResultsTotal - ($exportsTarTnResultsTotal + $insideTarTnResultsTotal) - ($zatrElectResults[$this->equipIdRequest] + $zatrPrepResults + $prsCostResults + $expDayResults[$this->equipIdRequest] + $rentCostResult + $amortizaciyaResult);

            if ($operPrib > 0) {
                $kpnResult = $operPrib * 0.2;
            } else {
                $kpnResult = 0;
            }
            $data[$lastDateOfMonth]['Курс доллара'] = $rate->ex_rate_dol;

            foreach ($emppersExp as $emp){
                if(!$emp->barr_coef){
                    $emp->barr_coef  = 7.23;
                }
                $data[$lastDateOfMonth]['Дисконт '. $this->getRoute($emp->route_id)] = $item->discont;
                $data[$lastDateOfMonth]['Коэффициент баррелизации '.$this->getRoute($emp->route_id)] = $emp->barr_coef;
            }

            foreach ($discontExp as $item) {
                if(!$item->barr_coef){
                    $item->barr_coef  = 7.23;
                }
                $data[$lastDateOfMonth]['Дисконт '. $this->getRoute($emp->route_id)] = $item->discont;
                $data[$lastDateOfMonth]['Коэффициент баррелизации ' . $this->getRoute($emp->route_id)] = $item->barr_coef;
            }

            $data[$lastDateOfMonth]['Добыча нефти'] = $oil;

            $chistayaPribyl = $operPrib - $kpnResult;
            $svobodDenPotok = $chistayaPribyl - $buyCostResult + $amortizaciyaResult;
            $godovoiLiquid += $liquid;
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
            $godovoiZatrPrs += $prsCostResults;
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
        }
        $dds1 = ['BZF311010000', 'BZF311020000', 'BZF311050000', 'BZF311090000', 'BZF331990000'];
        $dds2 = ['BZF312050000', 'BZF311020000', 'BZF311050000', 'BZF311090000', 'BZF331990000']; // + $kpn
//        return view('economy_kenzhe.field_calculation.tarif')->with(compact('datat'));
        for ($month = 1; $month <= 12; $month++) {
            if ($month > 9){
                $monthname = $month;
            } else {
                $monthname = '0' . $month;
            }
            $lastDateOfMonth = date("Y-m-t", strtotime($year . '-' . $monthname . '-01'));
            $opiuOilNames = [];
            $this->getShowDataOnTree($this->opiuOilNames, $opiuValues, $opiuOilNames);
            foreach ($opiuOilNames as $oilName) {
                $opiuOilNames[] = [
                    'value' => $oilName['value'] / $godovoiOil * $data[$lastDateOfMonth]['Добыча нефти'],
                    'num' => $oilName['num'],
                    'name' => $oilName['name']
                ];
            }

            $opiuLiquidNames = [];
            $this->getShowDataOnTree($this->opiuLiquidNames, $opiuValues, $opiuLiquidNames);
            foreach ($opiuLiquidNames as $opiuLiquid) {
                $opiuLiquidNames[] = [
                    'value' => $opiuLiquid['value'] / $godovoiLiquid * $data[$lastDateOfMonth]['добыча жидкости'],
                    'num' => $opiuLiquid['num'],
                    'name' => $opiuLiquid['name']
                ];
            }

            $result = [];
            $this->getShowDataOnTree($this->opiuRaspMestor, $opiuValues, $result); // данные на отображение
            $opiuRaspMestor = [];
            $financeRashod = 0;
            foreach ($result as $opiu) {
                $opiuRaspMestor[] = [
                    'value' => $opiu['value'] / $totalWells * $activeWells, // расчет  ДОХОДЫ(ОПИУ) по скважинам
                    'num' => $opiu['num'],
                    'name' => $opiu['name']
                ];
                if($opiu['num'] =='B73000000000'){
                    $financeRashod += $opiu['value'] / $totalWells * $activeWells;
                }
            }
            $data[$lastDateOfMonth]['ОПЕРАЦИОННАЯ ПРИБЫЛЬ(+)/ УБЫТОК (-)'] = $operPrib - ($financeRashod + array_sum(array_column($opiuLiquidNames, 'value'))  + array_sum(array_column($opiuOilNames, 'value')));
            $data[$lastDateOfMonth]['ДОХОД/(УБЫТОК) ДО НАЛОГООБЛОЖЕНИЯ'] = $operPrib - (array_sum(array_column($opiuRaspMestor, 'value')) + array_sum(array_column($opiuLiquidNames, 'value'))  + array_sum(array_column($opiuOilNames, 'value')));
            $data[$lastDateOfMonth]['ЧИСТЫЙ ДОХОД/(УБЫТОК)'] = $data[$lastDateOfMonth]['ДОХОД/(УБЫТОК) ДО НАЛОГООБЛОЖЕНИЯ'] - $kpnResult;
            $data[$lastDateOfMonth]['ЧИСТЫЙ ДОХОД/(УБЫТОК)'] = $data[$lastDateOfMonth]['Чистая сумма ДС по операционной деятельности'] - $kpnResult;

            array_push($data[$lastDateOfMonth], $opiuOilNames);
            array_push($data[$lastDateOfMonth], $opiuLiquidNames);
            array_push($data[$lastDateOfMonth], $opiuRaspMestor);
        }



//        $data['ОПЕРАЦИОННАЯ ПРИБЫЛЬ(+)/ УБЫТОК (-)'] = $godovoiDohod - (array_sum($opiuOilNames) + array_sum($opiuLiquid) + array_sum($opiuRaspMestor) + $godovoiRent + $godovoiNdnpi + $godovoiEtp + $godovoiTrans);
        //ДОХОД/(УБЫТОК) ДО НАЛОГООБЛОЖЕНИЯ
//        $data['ЧИСТЫЙ ДОХОД/(УБЫТОК)'] = $data['ОПЕРАЦИОННАЯ ПРИБЫЛЬ(+)/ УБЫТОК (-)'] - $godovoiKpn;
//        $data['opiu_result'] = $opiuRaspMestor;
        $data['opiu_result']['ДОХОДЫ ОТ РЕАЛИЗАЦИИ ТОВАРОВ, РАБОТ, УСЛУГ'] = $godovoiDohod;
        $data['opiu_result']['Налог на добычу полезных ископаемых (НДПИ)'] = $godovoiNdnpi;
        $data['opiu_result']['Рентный налог на экспортир.сырую нефть, газовый конденсат'] = $godovoiRent;
        $data['opiu_result']['РЭкспортная таможенная пошлина ( ЭТП)'] = $godovoiEtp;
        $data['opiu_result']['Расходы по погрузке, транспортировке и хранению'] = $godovoiTrans;
        $data['opiu_result']['Добыча нефти за год'] = $godovoiOil;
        $data['opiu_result']['Добыча жидкости за год'] = $godovoiLiquid;
        return view('economy_kenzhe.field_calculation.index')->with(compact('companies', 'data', 'datas'));

    }

    public function getDirectionName($id)
    {
        return array_search($id, $this->exportDirections);
    }

    public function getRoute($id) // получить название маршрута по id
    {
        return array_search($id, $this->routes);
    }

    public function getTnRoute($id) // получить название маршрута по id
    {
        return array_search($id, $this->routesTn);
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
                        'num' => $value['num'],
                        'name' => $value['name'],
                        'value' => $value['plan_value'][2021],
                    ];
                }
            }
            return $result;
        }
    }

    public function getRateName($id){
        return array_search($id, $this->rates);
    }

    public function getOpiuName($num){

    }

    public function calculationETP($realizationNDO, $rate, $dollar){
        return $realizationNDO * $rate * $dollar;
    }

    public function totalTransportationCostYear($route, $scenarioFact, $companyId, $oilValume, $rate){
        $tarifTn = EcoRefsTarifyTn::where('route_id', $route)->where('sc_fa', $scenarioFact)->where('company_id', $companyId)->get();
        $data = [];
        $value = 0;
        foreach ($tarifTn as $tarif) {
            if ($tarif->exc_id == 1) { // Валюта тг
                $value += $oilValume * $tarif->tn_rate;
                $data['tarif'][$this->getRoute($tarif->route_id)][$tarif->date][$this->getTnRoute($tarif->branch_id)][] = $tarif->tn_rate . $this->getRateName($tarif->exc_id );
            } elseif ($tarif->exc_id == 2) { // Валюта доллар
                $value += $oilValume * $tarif->tn_rate * $rate->ex_rate_dol;
                $data['tarif'][$this->getRoute($tarif->route_id)][$tarif->date][$this->getTnRoute($tarif->branch_id)][] = $tarif->tn_rate. $this->getRateName($tarif->exc_id );
            } else {
                $value += $oilValume * $tarif->tn_rate * $rate->ex_rate_rub;
                $data['tarif'][$this->getRoute($tarif->route_id)][$tarif->date][$this->getTnRoute($tarif->branch_id)][] = $tarif->tn_rate. $this->getRateName($tarif->exc_id );
            }
        }
        $data['value'] = $value;
        return $data;
    }

}
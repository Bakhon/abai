<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Models\EconomyKenzhe\HandbookRepTt;
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

class FieldCalcController extends MainController
{
    const  ONE_YEAR = 365;
    const  SERVICE_TIME = 12;
    public $razrab = 5;
    public $defaultCooefBarr = 7.23;
    public $qoil = null;
    public $param = null;
    public $liq = null;
    public $insideMarketDirections = null;
    public $equipIdRequest = null;
    public $companyId = null;
    public $exportDirections = [];
    public $workday = 0;
    public $totalWells = 0;
    public $activeWells = 0;
    public $firstDateOfMonth = 0;
    public $year = null;

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
    ];

    public $opiuLiquidNames = [
        'BZ7001010100',
        'BZ7001012000',
        'BZ7001013000',
        'BZ7001015000',
        'BZ7001019900',
        'BZ7001050000'
    ];

    public $opiuOilNames = [
        'B71190010000', 'B71190030000', 'B71190050000', 'B71190990000', 'B71101000000',
        'B71103000000', 'B71107000000', 'B71108000000', 'B71109000000', 'B71111000000',
        'B71112030000', 'B71112010000', 'B71112020000', 'B71118010000', 'B71118020000',
        'B71118990000', 'B71124000000', 'B71136000000', 'B71138000000', 'B71140000000',
        'B71145000000', 'B71147010000', 'B71147020000', 'B71147030000', 'B71147040000',
        'B71147050000', 'B71147060000', 'B71147990000', 'B71150000000', 'B71155000000',
        'B71156000000', 'B71161000000', 'B71166000000', 'B71169000000', 'B71172010000',
        'B71172020000', 'B71172030000', 'B71172040000', 'B71172050000', 'B71172060000',
        'B71172070000', 'B71172080000', 'B71172090000', 'B71172100000', 'B71172110000',
        'B71172120000', 'B71172130000', 'B71172140000', 'B71172150000', 'B71172990000',
        'B71186000000', 'B71187000000', 'B71192000000', 'B71193000000', 'B71197000000',
        'B71197000001', 'B71197000002', 'B71199000000', 'B71199900000', 'B71100000097',
        'B71111000100', 'B71111000200', 'B71111000300', 'B71111000400', 'B71111000500',
        'B71111000600', 'B71111000700', 'B71111000800', 'B71170010000', 'B71170020100',
        'B71170020200', 'B71170020201', 'B71170020202', 'B71170020300', 'B71170029900',
        'B71170030100', 'B71170039900', 'B71180000000', 'B72101000000', 'B72103000000',
        'B72105000000', 'B72107000000', 'B72110000000', 'B72112040000', 'B72112010000',
        'B72112020000', 'B72112030000', 'B72118020000', 'B72118030000', 'B72118990000',
        'B72118010000', 'B72124000000', 'B72126000000', 'B72128000000', 'B72134000000',
        'B72136000000', 'B72137000000', 'B72138000000', 'B72140000000', 'B72145000000',
        'B72147010000', 'B72147020000', 'B72147030000', 'B72147040000', 'B72147050000',
        'B72147060000', 'B72147990000', 'B72148000000', 'B72149000000', 'B72150000000',
        'B72155000000', 'B72156000000', 'B72160000000', 'B72161000000', 'B72163000000',
        'B72165000000', 'B72166000000', 'B72167000000', 'B72168000000', 'B72169000000',
        'B72172010000', 'B72172020000', 'B72172030000', 'B72172040000', 'B72172050000',
        'B72172060000', 'B72172070000', 'B72172080000', 'B72172090000', 'B72172100000',
        'B72172110000', 'B72172120000', 'B72172130000', 'B72172140000', 'B72172150000',
        'B72172990000', 'B72179000000', 'B72182000000', 'B72186000000', 'B72187000000',
        'B72188000000', 'B72190070000', 'B72190080000', 'B72190090000', 'B72190100000',
        'B72190110000', 'B72190990100', 'B72190990200', 'B72190990300', 'B72190990400',
        'B72190999900', 'B72192000000', 'B72194000000', 'B72195000000', 'B72196000000',
        'B72197000000', 'B72197000001', 'B72197000002', 'B72198000000', 'B72199000000',
        'B72100000097', 'B72102000000', 'B72102100000', 'B72102110000', 'B72102120000',
        'B74204150000', 'B72165010000', 'B72165020000', 'B72165030000', 'B72165040000',
        'B72165060000', 'B72165070000', 'B72165080000', 'B62404030000', 'B72170010000',
        'B72170020100', 'B72170020200', 'B72170020201', 'B72170020202', 'B72170020203',
        'B72170020300', 'B72170029900', 'B72170030100', 'B72170039900', 'B72170030200',
        'B72180000000', 'B74204100000', 'B73001000000', 'B73099000000', 'B74100000000',
        'B74110010000', 'B74110020000', 'B74110030000', 'B74204000097', 'B74201000000',
        'B74202000000', 'B74203000000', 'B74204190000', 'B74205000000', 'B74206000000',
        'B74207000000', 'B74208000000', 'B74297000000', 'B74298000000', 'B74299000000',
        'B74283000000', 'B74800000000', 'B74300000000', 'B74401000000', 'B74501000000',
        'B75000000000', 'B91110301100', 'B91110301200', 'B91110300000', 'B77001010000',
        'B77001020000', 'B77001030000', 'B77001040000', 'B77002010000', 'B77002030000',
        'B77002040000', 'BZF402010000'
    ];

    public $kvl = ['BZ8050710400'];

    public $dds1 = ['BZF311010000', 'BZF311020000', 'BZF311050000', 'BZF311090000', 'BZF331990000'];

    public $dds2 = ['BZF312050000', 'BZF311020000', 'BZF311050000', 'BZF311090000', 'BZF331990000'];

    public function __construct()
    {
        $this->routes = EcoRefsRoutesId::pluck('id', 'name')->toArray();
        $this->routesTn = EcoRefsRouteTnId::pluck('id', 'name')->toArray();
        $this->rates = EcoRefsExc::pluck('id', 'name')->toArray();
        $this->scenarios = EcoRefsScFa::pluck('id', 'name')->toArray();
        $this->exportDirections = EcoRefsDirectionId::where('name', 'Экспорт')->pluck('id', 'name');
        $this->insideMarketDirections = EcoRefsDirectionId::where('name', 'Внутренний рынок')->pluck('id', 'name');
        $this->opiuHandbook = HandbookRepTt::pluck('name', 'num');
    }

    public function index(Request $request)
    {
        $companies = EcoRefsCompaniesId::where('parent_id', '!=', 0)->get();
        $scenarioFact = 3;
        $reqDay = 365;
        $this->year = date('Y');
        if (isset($request->scenario)) {
            $scenarioFact = $request->scenario;
        }
        $this->qoil = 3.697;
        $this->reqecn = $request->reqecn;
        $this->param = $request->param;
        $this->liq = 91.3;
        $this->companyId = $request->company;
        $this->equipIdRequest = $request->equip ?? 1;
        $typesOfEquipment = EcoRefsEquipId::pluck('id');
        $company = EcoRefsCompaniesId::find($this->companyId)->first();
        $yearLiquid = null;
        $yearOil = null;
        $yearEmpper = null;
        $yearWorkday = null;
        $yearNdo = null;
        $yearDohod = null;
        $yearNdnpi = null;
        $yearRent = null;
        $yearEtp = null;
        $yearTrans = null;
        $yearZatrElectrShgn = null;
        $yearZatrElectrEcn = null;
        $yearZatrPrep = null;
        $yearZatrPrs = null;
        $yearZatrSutObs = null;
        $yearArenda = null;
        $yearAmortizacia = null;
        $yearOperPryb = null;
        $yearKpn = null;
        $yearChistPryb = null;
        $yearKvl = null;
        $yearSvobPot = null;
        $yearShgnParam = null;
        $yearEcnParam = null;
        $nakoplSvobPotok = null;
        $discSvobPotok = null;
        $nakopDiscSvodPotok = null;
        $npv = null;


        $this->totalWells = 3421;
        $this->activeWells = 35;

        if ($company) {
            $repTtValues = $this->getRepTtValues($company);
        }
        $this->sumOverTree($repTtValues);

        $ecnParam = 95.343 * pow($this->liq, -0.607);
        $shgnParam = 108.29 * pow($this->liq, -0.743);

        for ($month = 1; $month <= 12; $month++) {
            $exportsNdpiResults = [];
            $exportsRentTaxResults = [];
            $exportsEtpResults = [];
            $exportsTarTnResults = [];

            if ($month > 9) {
                $monthname = $month;
            } else {
                $monthname = '0' . $month;
            }
            $lastDateOfMonth = date("Y-m-t", strtotime($this->year . '-' . $monthname . '-01'));
            $this->firstDateOfMonth = date("Y-m-d", strtotime($this->year . '-' . $monthname . '-01'));
            $lastDay = date("d", strtotime($lastDateOfMonth));
            $rate = EcoRefsMacro::where('date', '=', $this->firstDateOfMonth)->first();
            $emppersExp = EcoRefsEmpPer::whereIn('direction_id', $this->exportDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $this->firstDateOfMonth)->get();
            $discontExp = EcoRefsDiscontCoefBar::whereIn('direction_id', $this->exportDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $this->firstDateOfMonth)->get();
            $electricityCosts = EcoRefsPrepElectPrsBrigCost::where('company_id', $this->companyId)->where('sc_fa', $scenarioFact)->where('date', $this->firstDateOfMonth)->get();
            $equipmentCosts = EcoRefsRentEquipElectServCost::whereIn('equip_id', $typesOfEquipment)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->whereYear('date', $this->year)->get();
            $buyCostResult = EcoRefsRentEquipElectServCost::where('equip_id', $this->equipIdRequest)->where('company_id', $this->companyId)->first()->equip_cost;
            $prsResult = $this->getPrs($electricityCosts, $reqDay);
            $avgprsday = $this->getAveragePrsDay($this->firstDateOfMonth);
            $this->workday = $lastDay * ((self::ONE_YEAR - array_sum($prsResult) * $avgprsday) / self::ONE_YEAR);
            $liquid = $this->liq * $this->workday;
            $oil = $this->getOilProduction();
            $percentRealization = $this->getPercentRealization();
            $empper = $oil - $oil * $percentRealization;
            $data[$lastDateOfMonth]['production_on_realization']['full'] = $empper;
            $data[$lastDateOfMonth]['fluid_production'] = $liquid;
            $data[$lastDateOfMonth]['oil_production'] = $oil;
            $result = $this->getProductionOnRealization($emppersExp, $empper);
            $exportsResults = $result['exportsResults'];
            $data[$lastDateOfMonth]['production_on_realization'] = $result['production_on_realization'];
            $exportsResultsTotal = array_sum($exportsResults);

            $result = $this->getPrsCostsResult($electricityCosts, $liquid, $avgprsday, $prsResult);
            $zatrPrepResults = $result['zatrPrepResults'];
            $prsCostResults = $result['prsCostResults'];
            $zatrElectResults = $this->getElectricityCostsByEquipment($equipmentCosts, $shgnParam, $ecnParam);
            $expDayResults = $this->getExpDayResutl($equipmentCosts);


            $rentCostResult = 0;

            if ($this->equipIdRequest != 1) {
                $rentCostResult = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->first()->rent_cost;
            }

            foreach ($exportsResults as $route_id => $oilValume) {
                $tarifTnItemValue = $this->totalTransportationCostYear($route_id, $scenarioFact, $this->companyId, $oilValume, $rate);
                $exportsTarTnResults[$route_id] = $tarifTnItemValue['value'] / 12;
                $data[$lastDateOfMonth]['oil_transportation'][$this->getRoute($route_id)] = $tarifTnItemValue['value'] / 12;
            }
            $exportsTarTnResultsTotal = array_sum($exportsTarTnResults);

            foreach ($discontExp as $item) {
                if (!$item->barr_coef) {
                    $item->barr_coef = $this->defaultCooefBarr;
                }
                $data[$lastDateOfMonth]['income_from_realization'][$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * (($item->macro - $item->discont) * $rate->ex_rate_dol);
                $stavki = EcoRefsNdoRates::where('company_id', $item->company_id)->first();
                $exportsNdpiResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rate->ex_rate_dol * $stavki->ndo_rates;
                $data[$lastDateOfMonth]['ndpi_oil_export'] = $exportsNdpiResults[$item->route_id];
                $rent = EcoRefsRentTax::where('world_price_beg', '<', $item->macro)->where('world_price_end', '<=', $item->macro)->first();
                $exportsRentTaxResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rent->rate * $rate->ex_rate_dol;
                $etpRate = EcoRefsAvgMarketPrice::where('avg_market_price_beg', '>=', $item->macro)->where('avg_market_price_end', '>', $item->macro)->first();
                $exportsEtpResults[$item->route_id] = $this->calculationETP($exportsResults[$item->route_id], $etpRate->exp_cust_duty_rate, $rate->ex_rate_dol);
                $data[$lastDateOfMonth]['etp'][$this->getRoute($item->route_id)] = $exportsEtpResults[$item->route_id];
            }
            $exportsDiscontResultsTotal = array_sum($data[$lastDateOfMonth]['income_from_realization']);
            $exportsNdpiResultsTotal = array_sum($exportsNdpiResults);
            $exportsRentTaxResultsTotal = array_sum($exportsRentTaxResults);
            $exportsEtpResultsTotal = array_sum($exportsEtpResults);

            $emppersIns = EcoRefsEmpPer::whereIn('direction_id', $this->insideMarketDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $this->firstDateOfMonth)->get();
            $discontIns = EcoRefsDiscontCoefBar::whereIn('direction_id', $this->insideMarketDirections)->where('sc_fa', $scenarioFact)->where('company_id', $this->companyId)->where('date', $this->firstDateOfMonth)->get();

            $insideDiscontResults = [];
            $insideNdpiResults = [];
            $insideTarTnResults = [];

            $result = $this->getProductionOnRealization($emppersIns, $empper);
            $insideResults = $result['exportsResults'];
            $data[$lastDateOfMonth]['production_on_realization'] = $result['production_on_realization'];
            $insideResultsTotal = array_sum($insideResults);

            foreach ($discontIns as $item) {
                $insideDiscontResults[$item->route_id] = $insideResults[$item->route_id] * $item->macro;
                $data[$lastDateOfMonth]['income_from_realization'][$this->getRoute($item->route_id)] = $insideDiscontResults[$item->route_id];
                $insideNdpiResults[$item->route_id] = $insideResults[$item->route_id] * $item->macro * $stavki->ndo_rates * 0.5;
                $data[$lastDateOfMonth]['ndpi_oil_inside_market'][$this->getRoute($item->route_id)] = $insideNdpiResults[$item->route_id];
            }
            $insideDiscontResultsTotal = array_sum($insideDiscontResults);
            $insideNdpiResultsTotal = array_sum($insideNdpiResults);

            foreach ($insideResults as $route_id => $oilValume) {
                $tarifTnItemValue = $this->totalTransportationCostYear($route_id, $scenarioFact, $this->companyId, $oilValume, $rate);
                $insideTarTnResults[$route_id] = $tarifTnItemValue['value'] / 12;
                $data[$lastDateOfMonth]['oil_transportation'][$this->getRoute($route_id)] = $insideTarTnResults[$route_id] / 12;
            }
            $insideTarTnResultsTotal = array_sum($insideTarTnResults);

            $amortizaciyaResult = $this->depreciationResult();

            $operPrib = ($exportsDiscontResultsTotal + $insideDiscontResultsTotal) - ($exportsNdpiResultsTotal + $insideNdpiResultsTotal) - $exportsRentTaxResultsTotal - $exportsEtpResultsTotal - ($exportsTarTnResultsTotal + $insideTarTnResultsTotal) - ($zatrElectResults[$this->equipIdRequest] + $zatrPrepResults + $prsCostResults + $expDayResults[$this->equipIdRequest] + $rentCostResult + $amortizaciyaResult);

            if ($operPrib > 0) {
                $kpnResult = $operPrib * 0.2;
            } else {
                $kpnResult = 0;
            }

            $chistayaPribyl = $operPrib - $kpnResult;
            $svobodDenPotok = $chistayaPribyl - $buyCostResult + $amortizaciyaResult;
            $yearLiquid += $liquid;
            $yearOil += $oil;
            $yearEmpper += $empper;
            $yearWorkday += $this->workday;
            $yearNdo = $yearNdo + $exportsResultsTotal + $insideResultsTotal;
            $yearDohod += $exportsDiscontResultsTotal + $insideDiscontResultsTotal;
            $yearNdnpi += $exportsNdpiResultsTotal + $insideNdpiResultsTotal;
            $yearRent += $exportsRentTaxResultsTotal;
            $yearEtp += $exportsEtpResultsTotal;
            $yearTrans += $exportsTarTnResultsTotal + $insideTarTnResultsTotal;
            $yearZatrElectrShgn += $zatrElectResults[1];
            $yearZatrElectrEcn += $zatrElectResults[2];
            $yearZatrPrep += $zatrPrepResults;
            $yearZatrPrs += $prsCostResults;
            $yearZatrSutObs += $expDayResults[1];
            $yearArenda += $rentCostResult;
            $yearAmortizacia += $amortizaciyaResult;
            $yearOperPryb += $operPrib;
            $yearKpn += $kpnResult;
            $yearChistPryb += $chistayaPribyl;
            $yearKvl += $buyCostResult;
            $yearSvobPot += $svobodDenPotok;
            $yearShgnParam += $shgnParam * $this->liq * $this->workday;
            $yearEcnParam += $ecnParam * $this->liq * $this->workday;
            $nakoplSvobPotok += $svobodDenPotok;
            $discSvobPotok += $nakoplSvobPotok;
            $nakopDiscSvodPotok += $discSvobPotok;
            $npv += $svobodDenPotok;
        }
        for ($month = 1; $month <= 12; $month++) {
            if ($month > 9) {
                $monthname = $month;
            } else {
                $monthname = '0' . $month;
            }
            $lastDateOfMonth = date("Y-m-t", strtotime($this->year . '-' . $monthname . '-01'));
            $opiuOilNames = [];
            $this->getShowDataOnTree($this->opiuOilNames, $repTtValues, $opiuOilNames);
            $this->getRepTtByOilCalc($opiuOilNames, $yearOil, $data[$lastDateOfMonth]['oil_production']);

            $opiuLiquidNames = [];
            $this->getShowDataOnTree($this->opiuLiquidNames, $repTtValues, $opiuLiquidNames);
            $opiuLiquidNames = $this->getRepTtByLiquidCalc($opiuLiquidNames, $data[$lastDateOfMonth]['fluid_production'], $yearLiquid);

            $distributionOilField = [];
            $this->getShowDataOnTree($this->opiuRaspMestor, $repTtValues, $distributionOilField);
            $distributionOilField = $this->getFieldDistributionCalc($distributionOilField);

            $data[$lastDateOfMonth]['operation_profit'] = $operPrib - ($distributionOilField['finance_costs'] + array_sum(array_column($opiuLiquidNames, 'value')) + array_sum(array_column($opiuOilNames, 'value')));
            $data[$lastDateOfMonth]['income_before_tax'] = $operPrib - (array_sum(array_column($distributionOilField['field_distribution'], 'value')) + array_sum(array_column($opiuLiquidNames, 'value')) + array_sum(array_column($opiuOilNames, 'value')));
            $data[$lastDateOfMonth]['net_income'] = $data[$lastDateOfMonth]['income_before_tax'] - $kpnResult;
            array_push($data[$lastDateOfMonth], $opiuOilNames);
            array_push($data[$lastDateOfMonth], $opiuLiquidNames);
            array_push($data[$lastDateOfMonth], $distributionOilField['field_distribution']);
        }

        $data['income_from_realization_products_services'] = $yearDohod;
        $data['ndpi'] = $yearNdnpi;
        $data['rent_tax_export_crude_oil'] = $yearRent;
        $data['etp'] = $yearEtp;
        $data['loading_transport_storage'] = $yearTrans;
        $data['oil_production_year'] = $yearOil;
        $data['liquid_production_year'] = $yearLiquid;
        return view('economy_kenzhe.field_calculation.index')->with(compact('companies', 'data'));
    }


    public function getDirectionName(int $id): string
    {
        return array_search($id, $this->exportDirections);
    }

    public function getRoute(int $id): string
    {
        return array_search($id, $this->routes);
    }

    public function getTnRoute(int $id): string
    {
        return array_search($id, $this->routesTn);
    }

    public function getRateName(int $id): string
    {
        return array_search($id, $this->rates);
    }

    public function getExpDayResutl(Object $equipmentCosts) : array
    {
        $data = [];
        foreach ($equipmentCosts as $item) {
            $data[$item->equip_id] = $this->workday * $item->dayli_serv_cost;
        }
        return $data;
    }

    public function getProductionOnRealization($emppersExp, $empper) : array
    {
        $data = [];
        foreach ($emppersExp as $item) {
            $data['exportsResults'][$item->route_id] = $empper * $item->emp_per;
            $data['production_on_realization'][$this->getRoute($item->route_id)] = $empper * $item->emp_per;
        }
        return $data;
    }

    public function getPrsCostsResult(Object $electricityCosts, float $liquid, float $avgprsday, array $prsResult) : array
    {
        $data = [];
        foreach ($electricityCosts as $item) {
            $data['zatrPrepResults'] = $liquid * $item->trans_prep_cost;
            $data['prsCostResults'] = array_sum($prsResult) / 12 * $avgprsday * $item->prs_brigade_cost;
        }
        return $data;
    }

    public function getPercentRealization(): float
    {
        $percentRealization = EcoRefsProcDob::where('company_id', $this->companyId)->where('date', $this->firstDateOfMonth)->first();

        if ($percentRealization) {
            $percentRealization = $percentRealization->proc_dob;
        }
        return $percentRealization;
    }

    public function getAveragePrsDay(): float
    {
        $avgprsday = EcoRefsAvgPrs::where('company_id', $this->companyId)->where('date', $this->firstDateOfMonth)->first();

        if ($avgprsday) {
            $avgprsday = $avgprsday->avg_prs;
        } else {
            $avgprsday = 0;
        }
        return $avgprsday;
    }

    public function getRepTtByOilCalc(array $opiuOilNames, float $yearOil, float $monthOil): array
    {
        foreach ($opiuOilNames as $oilName) {
            $opiuOilNames[] = [
                'value' => $oilName['value'] / $yearOil * $monthOil,
                'num' => $oilName['num'],
                'name' => $oilName['name']
            ];
        }
        return $opiuOilNames;
    }

    public function getRepTtByLiquidCalc(array $opiuLiquidNames, float $fluid_production, float $yearLiquid): array
    {
        foreach ($opiuLiquidNames as $opiuLiquid) {
            $opiuLiquidNames[] = [
                'value' => $opiuLiquid['value'] / $yearLiquid * $fluid_production,
                'num' => $opiuLiquid['num'],
                'name' => $opiuLiquid['name']
            ];
        }
        return $opiuLiquidNames;
    }

    public function getFieldDistributionCalc(array $result): array
    {
        $data = [];
        $data['finance_costs'] = 0;
        foreach ($result as $opiu) {
            $data['field_distribution'][] = [
                'value' => $opiu['value'] / $this->totalWells * $this->activeWells,
                'num' => $opiu['num'],
                'name' => $opiu['name']
            ];
            if ($opiu['num'] == 'B73000000000') {
                $data['finance_costs'] += $opiu['value'] / $this->totalWells * $this->activeWells;
            }
        }
        return $data;
    }

    public function getRepTtValues(EcoRefsCompaniesId $company): array
    {
        $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
        $companyRepTtValues = $company->statsByDate($this->year)->get()->toArray();
        $opiuValues = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $this->year, $this->year - 1, $this->year . '-01-01', $this->year . '-12-01');
        return $opiuValues;
    }

    public function getPrs(object $electricityCosts, int $reqDay): array
    {
        foreach ($electricityCosts as $cost) {
            $avgprsday = EcoRefsAvgPrs::where('company_id', $cost->company_id)->where('date', $this->firstDateOfMonth)->first();
            if ($avgprsday) {
                $avgprsday = $avgprsday->avg_prs;
            }
            if ($this->param == 1 && $reqDay >= self::ONE_YEAR) {
                $prsResult[$cost->company_id] = self::ONE_YEAR / ($reqDay);
            } else {
                $prsResult[$cost->company_id] = self::ONE_YEAR / ($reqDay + $avgprsday);
            }
        }
        return $prsResult;
    }

    public function getShowDataOnTree(array $names, array &$values, array &$result = []): array
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
                        'value' => $value['plan_value'][$this->year],
                    ];
                }
            }
        }
        return $result;
    }

    public function depreciationResult(): float
    {
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
        return $amortizaciyaResult;
    }

    public function getOilProduction(): float
    {
        return $this->qoil * (1 - exp(log(1 - $this->razrab / 100) / self::ONE_YEAR * $this->workday)) / -(log(1 - $this->razrab / 100) / self::ONE_YEAR);
    }

    public function calculationETP(float $realizationNDO, int $rate, int $dollar): float
    {
        return $realizationNDO * $rate * $dollar;
    }

    public function getElectricityCostsByEquipment($equipmentCosts, $shgnParam, $ecnParam): array
    {
        foreach ($equipmentCosts as $item) {
            $electCost = EcoRefsPrepElectPrsBrigCost::where('company_id', '=', $item->company_id)->first();
            if ($item->equip_id == 1) {
                $zatrElectResults[$item->equip_id] = $this->workday * $this->liq * $shgnParam * $electCost->elect_cost;
            } else {
                $zatrElectResults[$item->equip_id] = $this->workday * $this->liq * $ecnParam * $electCost->elect_cost;
            }
        }
        return $zatrElectResults;
    }

    public function totalTransportationCostYear(int $route, int $scenarioFact, int $companyId, float $oilValume, object $rate): array
    {
        $tarifTn = EcoRefsTarifyTn::where('route_id', $route)->where('sc_fa', $scenarioFact)->where('company_id', $companyId)->get();
        $data = [];
        $value = 0;
        foreach ($tarifTn as $tarif) {
            if ($tarif->exc_id == 1) {
                $value += $oilValume * $tarif->tn_rate;
                $data['tarif'][$this->getRoute($tarif->route_id)][$tarif->date][$this->getTnRoute($tarif->branch_id)][] = $tarif->tn_rate . $this->getRateName($tarif->exc_id);
            } elseif ($tarif->exc_id == 2) {
                $value += $oilValume * $tarif->tn_rate * $rate->ex_rate_dol;
                $data['tarif'][$this->getRoute($tarif->route_id)][$tarif->date][$this->getTnRoute($tarif->branch_id)][] = $tarif->tn_rate . $this->getRateName($tarif->exc_id);
            } else {
                $value += $oilValume * $tarif->tn_rate * $rate->ex_rate_rub;
                $data['tarif'][$this->getRoute($tarif->route_id)][$tarif->date][$this->getTnRoute($tarif->branch_id)][] = $tarif->tn_rate . $this->getRateName($tarif->exc_id);
            }
        }
        $data['value'] = $value;
        return $data;
    }

    public function sumOverTree(array &$items, array &$parent = null): array
    {
        if (is_array($items)) {
            foreach ($items as &$item) {
                if (count($item['handbook_items']) > 0) {
                    $item['handbook_items'] = self::sumOverTree($item['handbook_items'], $item);
                }
                if ($parent != null) {
                    $values = array_column($parent['handbook_items'], 'plan_value');
                    foreach ($values as $value) {
                        if ($value[$this->year] < 0) {
                            $value[$this->year] = $value[$this->year] * -1;
                        }
                        $parent['plan_value'][$this->year] += $value[$this->year];
                    }
                }
            }
            return $items;
        }
    }
}
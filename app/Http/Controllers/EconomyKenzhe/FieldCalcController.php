<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Http\Controllers\Controller;
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
use App\Models\EcoRefsServiceTime;
use App\Models\EcoRefsTarifyTn;
use App\Models\Refs\EcoRefsEmpPer;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;
use function Complex\ln;

class FieldCalcController extends Controller
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
    public $org = null;
    public $equipIdRequest = null;
    public $scorfa = null;


    public function nnoeco(Request $request)
    {
        $this->prs = $request->prs;
        $this->year = $request->date ?? '2021';
        $this->qZhidkosti = $request->qzh;
        $this->qoil = $request->qo;
        $this->reqDay = $request->reqd;
        $this->reqecn = $request->reqecn;
        $this->param = $request->param;
        $this->liq = $request->liq;
        $this->org = $request->org;
        $this->equipIdRequest = $request->equip;
        $this->scorfa = $request->scfa;

        // NDO podschet po marshrutam
        // Export BEGIN
        $exports = EcoRefsDirectionId::where('name', '=', 'Экспорт')->pluck('id')->toArray();
        $scfa = EcoRefsScFa::where('name', '=', $this->scorfa)->pluck('id')->toArray();

        // COMPANII не понятно зачем использовать
        $company = EcoRefsCompaniesId::where('id' ,'>' ,0)->pluck('id')->toArray();

        // VIDY OBORUDOVANIYA
        $equip = EcoRefsEquipId::where('id' ,'>' ,0)->pluck('id');

        $result2 = [];
        $godovoiLiquid = null;
        $godovoiOil = null;
        $godovoiEmpper = null;
        $godovoiWorkday = null;
        $godovoiPrs = null;
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
        $pokupka = 0;


        for ($month = 1; $month <= 12; $month++) {
            if ($month > 9) {
                $monthname = $month;
            } else {
                $monthname = '0' . $month;
            }
            $lastDateOfMonth = date("Y-m-t", strtotime($this->year . '-' . $monthname . '-01'));
            $firstDateOfMonth = date("Y-m-d", strtotime($this->year . '-' . $monthname . '-01'));
            $lastDay = date("d", strtotime($lastDateOfMonth));

            $emppersExp = EcoRefsEmpPer::whereIn('direction_id', $exports)->where('sc_fa', $scfa[0])->where('company_id', $this->org)->where('date', $firstDateOfMonth)->get();
            $discontExp = EcoRefsDiscontCoefBar::whereIn('direction_id', $exports)->where('sc_fa', $scfa[0])->where('company_id', $this->org)->where('date', $firstDateOfMonth)->get();
            $compRas = EcoRefsPrepElectPrsBrigCost::where('company_id', $this->org)->where('sc_fa', $scfa[0])->where('date', $firstDateOfMonth)->get();
            $equipRas = EcoRefsRentEquipElectServCost::whereIn('equip_id', $equip)->where('sc_fa', $scfa[0])->where('company_id', $this->org)->whereYear('date', $this->year)->get();

            $exportsResults = [];
            $exportsDiscontResults = [];
            $exportsNdpiResults = [];
            $exportsRentTaxResults = [];
            $exportsEtpResults = [];
            $exportsTarTnResults = [];
            $exportsElectResults = [];
            $zatrPrepResults = [];
            $zatrElectResults = [];
            $expDayResults = [];
            $prsResult = [];

            foreach ($compRas as $item) {
                $avgprsday = EcoRefsAvgPrs::where('company_id', $item->company_id)->first();
                if ($this->param == 1) {
                    if ($this->reqDay >= self::ONE_YEAR) {
                        $prsResult[$item->company_id] = self::ONE_YEAR / ($this->reqDay);
                    } else {
                        $prsResult[$item->company_id] = self::ONE_YEAR / ($this->reqDay + $avgprsday->avg_prs);
                    }
                }
                if ($this->param == 2) {
                    if ($this->equipIdRequest == 1) {
                        $prsResult[$item->company_id] = self::ONE_YEAR / ($this->reqDay + $avgprsday->avg_prs);
                    } else {
                        $prsResult[$item->company_id] = $this->reqecn;
                    }
                }
            }
            $avgprsday = EcoRefsAvgPrs::where('company_id', $this->org)->first();

            $procent = (self::ONE_YEAR - array_sum($prsResult) * $avgprsday->avg_prs) / self::ONE_YEAR;

            $workday = $lastDay * $procent;
            $this->liquid = $this->qZhidkosti * $workday;
            $oil = $this->qoil * (1 - exp(log(1 - $this->razrab / 100) / self::ONE_YEAR * $workday)) / -(log(1 - $this->razrab / 100) / self::ONE_YEAR);
            $perreal = EcoRefsProcDob::where('company_id', $this->org)->first();
            $empper = $oil - $oil * $perreal->proc_dob;

            $ecnParam = 95.343 * pow($this->liq, -0.607);
            $shgnParam = 108.29 * pow($this->liq, -0.743);

            foreach ($emppersExp as $item) {
                $exportsResults[$item->route_id] = $empper * $item->emp_per;
            }
            $exportsResultsTotal = array_sum($exportsResults);

            foreach ($compRas as $item) {
                $zatrPrepResults[$item->company_id] = $this->liquid * $item->trans_prep_cost;
            }

            foreach ($equipRas as $item) {
                $electCost = EcoRefsPrepElectPrsBrigCost::where('company_id', '=', $item->company_id)->first();
                if ($item->equip_id == 1) {
                    $zatrElectResults[$item->equip_id] = $workday * $this->liq * $shgnParam * $electCost->elect_cost;
                } else {
                    $zatrElectResults[$item->equip_id] = $workday * $this->liq * $ecnParam * $electCost->elect_cost;
                }
            }

            foreach ($compRas as $item) {
                $this->prsCostResults[$item->company_id] = array_sum($prsResult) / 12 * $avgprsday->avg_prs * $item->prs_brigade_cost;
            }

            foreach ($equipRas as $item) {
                $expDayResults[$item->equip_id] = $workday * $item->dayli_serv_cost;
            }

            $rentCostResult = 0;

            if ($this->equipIdRequest != 1) {
                $rentCostResult = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->first()->rent_cost;
            }

            $buyCostResult = 0;

            if ($pokupka == 0) {
                if ($this->equipIdRequest == 1) {
                    $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->where('company_id', $this->org)->first();
                    $buyCostResult = $buyCost->equip_cost;
                }
                $pokupka = 1;
            }

            // TO DO
            foreach ($exportsResults as $key => $value) {
                $tarifTnExp = EcoRefsTarifyTn::where('route_id', $key)->where('sc_fa', $scfa[0])->where('company_id', $this->org)->get();
                $tarifTnItemValue = 0;
                foreach ($tarifTnExp as $row) {
                    if ($row->exc_id == 1) {
                        $tarifTnItemValue += $value * $row->tn_rate;
                    } elseif ($row->exc_id == 2) {
                        $rate = EcoRefsMacro::whereMonth('date', $monthname)->first();
                        $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_dol;
                    } else {
                        $rate = EcoRefsMacro::whereMonth('date', $monthname)->first();
                        $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_rub;
                    }
                }
                $exportsTarTnResults[$key] = $tarifTnItemValue / 12;
            }

            $exportsTarTnResultsTotal = array_sum($exportsTarTnResults);

            //To do rate->exp_dol
            foreach ($discontExp as $item) {
                $rate = EcoRefsMacro::where('date', '=', $item->date)->first();
                $exportsDiscontResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * (($item->macro - $item->discont) * $rate->ex_rate_dol);
            }
            $exportsDiscontResultsTotal = array_sum($exportsDiscontResults);

            // To DO
            foreach ($discontExp as $item) {
                $rate = EcoRefsMacro::where('date', '=', $item->date)->first();
                $stavki = EcoRefsNdoRates::where('company_id', '=', $item->company_id)->first();
                $exportsNdpiResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $stavki->ndo_rates * $rate->ex_rate_dol;
            }
            $exportsNdpiResultsTotal = array_sum($exportsNdpiResults);

            foreach ($discontExp as $item) {
                $rate = EcoRefsMacro::where('date', '=', $item->date)->first();
                $rent = EcoRefsRentTax::where('world_price_beg', '<', $item->macro)->where('world_price_end', '<=', $item->macro)->first();
                $exportsRentTaxResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rent->rate * $rate->ex_rate_dol;
            }
            $exportsRentTaxResultsTotal = array_sum($exportsRentTaxResults);

            foreach ($discontExp as $item) {
                $rate = EcoRefsMacro::where('date', '=', $item->date)->first();
                $etp = EcoRefsAvgMarketPrice::where('avg_market_price_beg', '>=', $item->macro)->where('avg_market_price_end', '>', $item->macro)->first();
                $exportsEtpResults[$item->route_id] = $exportsResults[$item->route_id] * $etp->exp_cust_duty_rate * $rate->ex_rate_dol;
            }
            $exportsEtpResultsTotal = array_sum($exportsEtpResults);


            // Export END

            // Inside BEGIN
            $directionIns = EcoRefsDirectionId::where('name', '=', 'Внутренний рынок')->get();
            $inside = [];

            foreach ($directionIns as $item) {
                array_push($inside, $item->id);
            }


            $emppersIns = EcoRefsEmpPer::whereIn('direction_id', $inside)->where('sc_fa', $scfa[0])->where('company_id', $this->org)->where('date', $firstDateOfMonth)->get();
            $discontIns = EcoRefsDiscontCoefBar::whereIn('direction_id', $inside)->where('sc_fa', $scfa[0])->where('company_id', $this->org)->where('date', $firstDateOfMonth)->get();

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
            // Inside END

            // Rabota s TOTALAMI
            foreach ($insideResults as $key => $value) {
                $tarifTnIns = EcoRefsTarifyTn::where('route_id', '=', $key)->where('sc_fa', $scfa[0])->where('company_id', $this->org)->get();
                $tarifTnItemValue = 0;
                foreach ($tarifTnIns as $row) {
                    if ($row->exc_id == 1) {
                        $tarifTnItemValue += $value * $row->tn_rate;
                    } elseif ($row->exc_id == 2) {
                        $rate = EcoRefsMacro::whereMonth('date', $monthname)->first();
                        $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_dol;
                    } else {
                        $rate = EcoRefsMacro::whereMonth('date', $monthname)->first();
                        $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_rub;
                    }
                }
                $insideTarTnResults[$key] = $tarifTnItemValue / 12;
            }
            $insideTarTnResultsTotal = array_sum($insideTarTnResults);

            // TO DO Vytashit' $serviceTime
            $amortizaciyaResult = [];

            if ($this->equipIdRequest == 1) {
                $srokSluzhby = EcoRefsServiceTime::where('equip_id', '=', $this->equipIdRequest)->where('company_id', '=', $this->org)->first();
                $equipCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->where('company_id', '=', $this->org)->first();
                if ($srokSluzhby->avg_serv_life > self::SERVICE_TIME) {
                    $amortizaciyaResult = $equipCost->equip_cost / $srokSluzhby->avg_serv_life;
                } else {
                    $amortizaciyaResult = 0;
                }
            } else {
                $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $this->equipIdRequest)->where('company_id', '=', $this->org)->first();
                $amortizaciyaResult = 0;
            }

            $operPrib = [];

            # TO DO
            foreach ($compRas as $item) {
                $operPrib[$item->company_id] = ($exportsDiscontResultsTotal + $insideDiscontResultsTotal) - ($exportsNdpiResultsTotal + $insideNdpiResultsTotal) - $exportsRentTaxResultsTotal - $exportsEtpResultsTotal - ($exportsTarTnResultsTotal + $insideTarTnResultsTotal) - ($zatrElectResults[$this->equipIdRequest] + $zatrPrepResults[$item->company_id] + $this->prsCostResults[$item->company_id] + $expDayResults[$this->equipIdRequest] + $rentCostResult + $amortizaciyaResult);
            }

            $kpnResult = [];

            foreach ($compRas as $item) {
                if ($operPrib[$item->company_id] > 0) {
                    $kpnResult[$item->company_id] = $operPrib[$item->company_id] * 0.2;
                } else {
                    $kpnResult[$item->company_id] = 0;
                }
            }

            $chistayaPribyl = [];

            foreach ($compRas as $item) {
                $chistayaPribyl[$item->company_id] = $operPrib[$item->company_id] - $kpnResult[$item->company_id];
            }

            $svobodDenPotok = [];

            foreach ($compRas as $item) {
                $svobodDenPotok[$item->company_id] = $chistayaPribyl[$item->company_id] - $buyCostResult + $amortizaciyaResult;
            }

            $godovoiLiquid = $godovoiLiquid + $this->liquid;
            $oil = $godovoiOil + $oil;
            $godovoiEmpper = $godovoiEmpper + $empper;
            $godovoiWorkday = $godovoiWorkday + $workday;
            $godovoiPrs = $godovoiPrs + $this->prs;
            $godovoiNdo = $godovoiNdo + $exportsResultsTotal + $insideResultsTotal;
            $godovoiDohod = $godovoiDohod + $exportsDiscontResultsTotal + $insideDiscontResultsTotal;
            $godovoiNdnpi = $godovoiNdnpi + $exportsNdpiResultsTotal + $insideNdpiResultsTotal;
            $godovoiRent = $godovoiRent + $exportsRentTaxResultsTotal;
            $godovoiEtp = $godovoiEtp + $exportsEtpResultsTotal;
            $godovoiTrans = $godovoiTrans + $exportsTarTnResultsTotal + $insideTarTnResultsTotal;
            $godovoiZatrElectrShgn = $godovoiZatrElectrShgn + $zatrElectResults[1];
            $godovoiZatrElectrEcn = $godovoiZatrElectrEcn + $zatrElectResults[2];
            $godovoiZatrPrep = $godovoiZatrPrep + array_sum($zatrPrepResults);
            $godovoiZatrPrs = $godovoiZatrPrs + array_sum($this->prsCostResults);
            $godovoiZatrSutObs = $godovoiZatrSutObs + $expDayResults[1];
            $godovoiArenda = $godovoiArenda + $rentCostResult;
            $godovoiAmortizacia = $godovoiAmortizacia + $amortizaciyaResult;
            $godovoiOperPryb = $godovoiOperPryb + array_sum($operPrib);
            $godovoiKpn = $godovoiKpn + array_sum($kpnResult);
            $godovoiChistPryb = $godovoiChistPryb + array_sum($chistayaPribyl);
            $godovoiKvl = $godovoiKvl + $buyCostResult;
            $godovoiSvobPot = $godovoiSvobPot + array_sum($svobodDenPotok);
            $godovoiShgnParam = $godovoiShgnParam + $shgnParam * $this->liq * $workday;
            $godovoiEcnParam = $godovoiEcnParam + $ecnParam * $this->liq * $workday;

            $nakoplSvobPotok = $nakoplSvobPotok + array_sum($svobodDenPotok);
            $discSvobPotok = $discSvobPotok + $nakoplSvobPotok;
            $nakopDiscSvodPotok = $nakopDiscSvodPotok + $discSvobPotok;
            $npv = $npv + array_sum($svobodDenPotok);

            $vdata2 = [
                'last' => $lastDateOfMonth,
                'day' => $lastDay,
                'year' => $this->year,
                'monthname' => $monthname,
                'liquid' => $this->liquid,
                'oil' => $oil,
                'empper' => $empper,
                'workday' => $workday,
                'prs' => array_sum($prsResult) / 12,
                'srednii' => $avgprsday->avg_prs,
                'exportsResultsTotal' => $exportsResultsTotal,
                'exportsResults' => $exportsResults,
                'insideResultsTotal' => $insideResultsTotal,
                'insideResults' => $insideResults,
                'exportsDiscontResultsTotal' => $exportsDiscontResultsTotal,
                'insideDiscontResultsTotal' => $insideDiscontResultsTotal,
                'insideDiscontResults' => $insideDiscontResults,
                'exportsNdpiResultsTotal' => $exportsNdpiResultsTotal,
                'exportsNdpiResults' => $exportsNdpiResults,
                'insideNdpiResultsTotal' => $insideNdpiResultsTotal,
                'insideNdpiResults' => $insideNdpiResults,
                'exportsRentTaxResultsTotal' => $exportsRentTaxResultsTotal,
                'exportsRentTaxResults' => $exportsRentTaxResults,
                'exportsEtpResultsTotal' => $exportsEtpResultsTotal,
                'exportsElectResults' => $exportsElectResults,
                'lexportsTarTnResultsTotal' => $exportsTarTnResultsTotal,
                'exportsTarTnResults' => $exportsTarTnResults,
                'insideTarTnResultsTotal' => $insideTarTnResultsTotal,
                'insideTarTnResults' => $insideTarTnResults,
                'zatrElectResults' => $zatrElectResults,
                'zatrPrepResults' => $zatrPrepResults,
                'prsCostResults' => $this->prsCostResults,
                'expDayResults' => $expDayResults,
                'rentCostResult' => $rentCostResult,
                'amortizaciyaResult' => $amortizaciyaResult,
                'operPrib' => $operPrib,
                'kpnResult' => $kpnResult,
                'chistayaPribyl' => $chistayaPribyl,
                'buyCostResult' => $buyCostResult,
                'svobodDenPotok' => $svobodDenPotok,
                'npv' => $npv,
                'shgnParam' => $shgnParam * $this->liq * $workday,
                'ecnParam' => $ecnParam * $this->liq * $workday,
            ];
            array_push($result2, $vdata2);
        }

        $godovoi = [
            'liquid' => $godovoiLiquid,
            'oil' => $godovoiOil,
            'empper' => $godovoiEmpper,
            'workday' => $godovoiWorkday,
            'kolichestvoPrs' => array_sum($prsResult),
            'sredniiPrs' => $avgprsday->avg_prs,
            'godovoiNdo' => $godovoiNdo,
            'godovoiDohod' => $godovoiDohod,
            'godovoiNdpi' => $godovoiNdnpi,
            'godovoiRent' => $godovoiRent,
            'godovoiEtp' => $godovoiEtp,
            'godovoiTrans' => $godovoiTrans,
            'godovoiZatrElectShgn' => $godovoiZatrElectrShgn,
            'godovoiZatrElectEcn' => $godovoiZatrElectrEcn,
            'godovoiZatrPrep' => $godovoiZatrPrep,
            'godovoiZatrPrs' => $godovoiZatrPrs,
            'godovoiZatrSutObs' => $godovoiZatrSutObs,
            'godovoiArenda' => $godovoiArenda,

            'godovoiAmortizacia' => $godovoiAmortizacia,
            'godovoiOperPryb' => $godovoiOperPryb,
            'godovoiKpn' => $godovoiKpn,
            'godovoiChistPryb' => $godovoiChistPryb,
            'godovoiKvl' => $godovoiKvl,
            'godovoiSvobPot' => $godovoiSvobPot,
            'npv' => $npv,
            'godovoiShgnParam' => $godovoiShgnParam,
            'godovoiEcnParam' => $godovoiEcnParam,

        ];

        array_push($result2, $godovoi);


        return response()->json($result2);
    }
}

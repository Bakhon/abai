<?php

namespace App\Http\Controllers\Refs;

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
use App\Models\EcoRefsRoutesId;
use App\Models\EcoRefsServiceTime;
use App\Models\EcoRefsTarifyTn;
use App\Models\Refs\EcoRefsEmpPer;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Exporter;

use function Complex\ln;

class EcoRefsScFaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsscfa = EcoRefsScFa::latest()->paginate(5);

        return view('ecorefsscfa.index',compact('ecorefsscfa'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecorefsscfa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        EcoRefsScFa::create($request->all());

        return redirect()->route('ecorefsscfa.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $EcoRefsScFa = EcoRefsScFa::find($id);
        return view('ecorefsscfa.edit',compact('EcoRefsScFa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $EcoRefsScFa=EcoRefsScFa::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsScFa->update($request->all());

        return redirect()->route('ecorefsscfa.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsScFa = EcoRefsScFa::find($id);
        $EcoRefsScFa->delete();

        return redirect()->route('ecorefsscfa.index')->with('success',__('app.deleted'));
        //
    }
    public function refsList(){
        return view('ecorefsscfa.list');
    }

    public function nnoeco(Request $request){
        $result = [];
        //$workday = $request->workday;
        $prs = $request->prs;
        //$avgprs = $request->avgprs;
        //$serviceTime = $request->time;

        $serviceTime = 12;

        $qZhidkosti = $request->qzh;
        $qoil = $request->qo;
        $reqDay = $request->reqd;
        $reqecn = $request->reqecn;
        $param=$request->param;

        $org = $request->org;
        $equipIdRequest = $request->equip;
        $scorfa = $request->scfa;

        $razrab = 5;
        $startdate ="2021-01-01";
        $month = 12;

        $procent=1;



        //$workday=$request;
        $monthname=[];
        // Raspredelenie po napravleniyam realizacii NDO
        // To do

        $periodcalc = EcoRefsMacro::where('date','>=',$startdate)->get();
        $periodc = [];

        foreach($periodcalc as $item){
            array_push($periodc,$item->date);
        }

        $result2=[];

        $godovoiLiquid=null;
        $godovoiOil=null;
        $godovoiEmpper=null;
        $godovoiWorkday=null;
        $godovoiPrs=null;
        $godovoiNdo=null;
        $godovoiDohod=null;
        $godovoiNdnpi=null;
        $godovoiRent=null;
        $godovoiEtp=null;
        $godovoiTrans=null;
        $godovoiZatrElectrShgn=null;
        $godovoiZatrElectrEcn=null;
        $godovoiZatrPrep=null;
        $godovoiZatrPrs=null;
        $godovoiZatrSutObs=null;
        $godovoiArenda=null;
        $godovoiAmortizacia=null;
        $godovoiOperPryb=null;
        $godovoiKpn= null;
        $godovoiChistPryb=null;
        $godovoiKvl=null;
        $godovoiSvobPot=null;
        $godovoiShgnParam=null;
        $godovoiEcnParam=null;
        $nakoplSvobPotok=null;
        $discSvobPotok=null;
        $nakopDiscSvodPotok=null;
        $npv=null;

        $pokupka=0;


        foreach($periodc as $element){


            $year=date("Y",strtotime($element));
            $monthname=date("m",strtotime($element));
            $lastDateOfMonth = date("Y-m-t", strtotime($element));
            $day=date("d", strtotime($lastDateOfMonth));

            $discont=EcoRefsDiscontCoefBar::whereMonth('date',$monthname)->first()->discont;



            // ------------------------NDO podschet po marshrutam
            // Export BEGIN
            $directionExp = EcoRefsDirectionId::where('name','=','Экспорт')->get();
            $exports = [];

            $scenariofact = EcoRefsScFa::where('name','=',$scorfa)->get();
            $scfa = [];

            foreach($scenariofact as $item){
                array_push($scfa,$item->id);
            }



            foreach($directionExp as $item){
                array_push($exports,$item->id);
            }

            // COMPANII
            $companyId = EcoRefsCompaniesId::get();
            $company = [];

            foreach($companyId as $item){
                array_push($company,$item->id);
            }

            // VIDY OBORUDOVANIYA
            $equipId = EcoRefsEquipId::get();
            $equip = [];

            foreach($equipId as $item){
                array_push($equip,$item->id);
            }


            // $emppersExp = EcoRefsEmpPer::whereIn('direction_id',$exports)->whereMonth('date',$monthname)->get();
            // $discontExp = EcoRefsDiscontCoefBar::where('direction_id',$exports)->whereMonth('date',$monthname)->get();
            // $compRas = EcoRefsPrepElectPrsBrigCost::where('company_id',$company)->whereMonth('date',$monthname)->get();
            //$equipRas = EcoRefsRentEquipElectServCost::whereIn('equip_id',$equip)->whereMonth('date',$monthname)->get();

            $emppersExp = EcoRefsEmpPer::whereIn('direction_id',$exports)->whereMonth('date',$monthname)->get();
            $discontExp = EcoRefsDiscontCoefBar::whereIn('direction_id',$exports)->whereMonth('date',$monthname)->get();
            $compRas = EcoRefsPrepElectPrsBrigCost::whereIn('company_id',$company)->whereMonth('date',$monthname)->get();
            $equipRas = EcoRefsRentEquipElectServCost::whereIn('equip_id',$equip)->whereYear('date',$year)->get();
            $workday=0;

            $exportsResults = [];
            $exportsDiscontResults = [];
            $exportsNdpiResults = [];
            $exportsRentTaxResults = [];
            $exportsEtpResults = [];
            $exportsTarTnResults = [];
            $exportsElectResults = [];
            $zatrPrepResults = [];
            $zatrElectResults = [];
            $prsCostResults = [];
            $expDayResults = [];
            $prsResult=[];




            foreach($compRas as $item){
                $avgprsday = EcoRefsAvgPrs::where('company_id', $item->company_id)->first();
                if($param == 1){
                    $prsResult[$item->company_id] = 365 / ($reqDay + $avgprsday->avg_prs);
                } else {
                    if($param == 2){
                        if($equipIdRequest == 1){
                            $prsResult[$item->company_id] = 365 / ($reqDay + $avgprsday->avg_prs);
                        }
                        else{
                            $prsResult[$item->company_id] = $reqecn;
                        }
                    }else{
                        if($equipIdRequest == 1){
                            $prsResult[$item->company_id] = $reqecn;
                        }
                        else{
                            $prsResult[$item->company_id] = 365 / ($reqDay + $avgprsday->avg_prs);
                        }
                    }
                }

            }

            //foreach($compRas as $item){
            $avgprsday = EcoRefsAvgPrs::where('company_id', $item->company_id)->first();

            $procent=(365-array_sum($prsResult) * $avgprsday->avg_prs)/365;


            $workday=$day*$procent;
            $liquid = $qZhidkosti * $workday;
            $oil = $qoil * (1 - exp(log(1 - $razrab/100) / 365 * $workday)) /-(log(1 - $razrab/100)/365);
            $perreal = EcoRefsProcDob::where('company_id', $org)->first();
            $empper = $oil - $oil * $perreal->proc_dob;




            $ecnParam = 95.343 * pow($qZhidkosti,-0.607);
            $shgnParam = 108.29 * pow($qZhidkosti,-0.743);

            foreach($emppersExp as $item){
                $exportsResults[$item->route_id] = $empper * $item->emp_per;
            }
            $exportsResultsTotal = array_sum($exportsResults);

            foreach($compRas as $item){
                $zatrPrepResults[$item->company_id] = $liquid * $item->trans_prep_cost;
            }

            foreach($equipRas as $item){
                $electCost = EcoRefsPrepElectPrsBrigCost::where('company_id', '=', $item->company_id)->whereMonth('date',$monthname)->first();
                if($item->equip_id == 1){
                    $zatrElectResults[$item->equip_id] = $workday * $qZhidkosti * $shgnParam * $electCost->elect_cost;
                }
                else{
                    $zatrElectResults[$item->equip_id] = $workday  * $qZhidkosti * $ecnParam * $electCost->elect_cost;
                }
            }

            foreach($compRas as $item){
                $prsCostResults[$item->company_id] = array_sum($prsResult)/12 * $avgprsday->avg_prs * $item->prs_brigade_cost;
            }

            foreach($equipRas as $item){
                $expDayResults[$item->equip_id] = $workday * $item->dayli_serv_cost;
            }

            $rentCostResult = 0;

            if($equipIdRequest == 1){
                $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $equipIdRequest)->first();
                $rentCostResult = 0;
            }
            else{
                $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $equipIdRequest)->first();
                $rentCostResult = $buyCost->rent_cost * $workday/30;
            }


            $buyCostResult = 0;

            if($pokupka==0){
                if($equipIdRequest == 1){
                    $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $equipIdRequest)->first();
                    $buyCostResult = $buyCost->equip_cost;
                }
                else{
                    $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $equipIdRequest)->first();
                    $buyCostResult = 0;
                }
                $pokupka=1;
            }



            // TO DO
            foreach($exportsResults as $key => $value){
                $tarifTnExp = EcoRefsTarifyTn::where('route_id',$key)->get();
                $tarifTnItemValue = 0;
                foreach($tarifTnExp as $row){
                    if ($row->exc_id == 1){
                        $tarifTnItemValue += $value * $row->tn_rate;
                    }elseif($row->exc_id == 2){
                        $rate = EcoRefsMacro::whereMonth('date',$monthname)->first();
                        $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_dol;
                    }else{
                        $rate = EcoRefsMacro::whereMonth('date',$monthname)->first();
                        $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_rub;
                    }
                }
                $exportsTarTnResults[$key] = $tarifTnItemValue/12;
            }

            $exportsTarTnResultsTotal = array_sum($exportsTarTnResults);

            //To do rate->exp_dol
            foreach($discontExp as $item){
                $rate = EcoRefsMacro::where('date','=',$item->date)->first();
                $exportsDiscontResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * (($item->macro - $item->discont) * $rate->ex_rate_dol);
            }
            $exportsDiscontResultsTotal = array_sum($exportsDiscontResults);

            // To DO
            foreach($discontExp as $item){
                $rate = EcoRefsMacro::where('date','=',$item->date)->first();
                $stavki = EcoRefsNdoRates::where('company_id','=',$item->company_id)->first();
                $exportsNdpiResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $stavki->ndo_rates * $rate->ex_rate_dol;
            }
            $exportsNdpiResultsTotal = array_sum($exportsNdpiResults);

            foreach($discontExp as $item){
                $rate = EcoRefsMacro::where('date','=',$item->date)->first();
                $rent = EcoRefsRentTax::where('world_price_beg','<',$item->macro)->where('world_price_end','<=',$item->macro)->first();
                $exportsRentTaxResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rent->rate * $rate->ex_rate_dol;
            }
            $exportsRentTaxResultsTotal = array_sum($exportsRentTaxResults);

            foreach($discontExp as $item){
                $rate = EcoRefsMacro::where('date','=',$item->date)->first();
                $etp = EcoRefsAvgMarketPrice::where('avg_market_price_beg','>=',$item->macro)->where('avg_market_price_end','>',$item->macro)->first();
                $exportsEtpResults[$item->route_id] = $exportsResults[$item->route_id] * $etp->exp_cust_duty_rate * $rate->ex_rate_dol;
            }
            $exportsEtpResultsTotal = array_sum($exportsEtpResults);


            // Export END

            // Inside BEGIN
            $directionIns = EcoRefsDirectionId::where('name','=','Внутренний рынок')->get();
            $inside = [];

            foreach($directionIns as $item){
                array_push($inside,$item->id);
            }


            $emppersIns = EcoRefsEmpPer::whereIn('direction_id',$inside)->get();
            $discontIns = EcoRefsDiscontCoefBar::whereIn('direction_id',$inside)->get();

            $insideResults = [];
            $insideDiscontResults = [];
            $insideNdpiResults = [];
            $insideTarTnResults = [];

            foreach($emppersIns as $item){
                $insideResults[$item->route_id] = $empper * $item->emp_per;
            }
            $insideResultsTotal = array_sum($insideResults);

            foreach($discontIns as $item){
                $insideDiscontResults[$item->route_id] = $insideResults[$item->route_id]*$item->macro;
            }
            $insideDiscontResultsTotal = array_sum($insideDiscontResults);

            foreach($discontIns as $item){
                $insideNdpiResults[$item->route_id] = $insideResults[$item->route_id]*$item->macro * $stavki->ndo_rates * 0.5;
            }

            $insideNdpiResultsTotal = array_sum($insideNdpiResults);
            // Inside END

            // Rabota s TOTALAMI

            foreach($insideResults as $key => $value){
                $tarifTnIns = EcoRefsTarifyTn::where('route_id','=',$key)->get();
                $tarifTnItemValue = 0;
                foreach($tarifTnIns as $row){
                    if ($row->exc_id == 1){
                        $tarifTnItemValue += $value * $row->tn_rate;
                    }elseif($row->exc_id == 2){
                        $rate = EcoRefsMacro::whereMonth('date',$monthname)->first();
                        $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_dol;
                    }else{
                        $rate = EcoRefsMacro::whereMonth('date',$monthname)->first();
                        $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_rub;
                    }
                }
                $insideTarTnResults[$key] = $tarifTnItemValue/12;
            }
            $insideTarTnResultsTotal = array_sum($insideTarTnResults);

            // TO DO Vytashit' $serviceTime
            $amortizaciyaResult = [];

            if($equipIdRequest == 1){
                $srokSluzhby = EcoRefsServiceTime::where('equip_id', '=', $equipIdRequest)->first();
                $equipCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $equipIdRequest)->first();
                if($srokSluzhby->avg_serv_life > $serviceTime){
                    $amortizaciyaResult = $equipCost->equip_cost / $srokSluzhby->avg_serv_life;
                }
                else{
                    $amortizaciyaResult = 0;
                }
            }
            else{
                $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $equipIdRequest)->first();
                $amortizaciyaResult = 0;
            }


            $operPrib = [];

            # TO DO
            foreach($compRas as $item){
                $operPrib[$item->company_id] = ($exportsDiscontResultsTotal + $insideDiscontResultsTotal) - ($exportsNdpiResultsTotal + $insideNdpiResultsTotal) - $exportsRentTaxResultsTotal - $exportsEtpResultsTotal - ($exportsTarTnResultsTotal + $insideTarTnResultsTotal) - ($zatrElectResults[$equipIdRequest] + $zatrPrepResults[$item->company_id] + $prsCostResults[$item->company_id] + $expDayResults[$equipIdRequest] + $rentCostResult + $amortizaciyaResult);
            }


            $kpnResult = [];

            foreach($compRas as $item){
                if($operPrib[$item->company_id]>0){
                    $kpnResult[$item->company_id] = $operPrib[$item->company_id] * 0.2;
                }
                else{
                    $kpnResult[$item->company_id] = 0;
                }
            }

            $chistayaPribyl = [];

            foreach($compRas as $item){
                $chistayaPribyl[$item->company_id] = $operPrib[$item->company_id] - $kpnResult[$item->company_id];
            }

            $svobodDenPotok = [];

            foreach($compRas as $item){
                $svobodDenPotok[$item->company_id] = $chistayaPribyl[$item->company_id] -  $buyCostResult + $amortizaciyaResult;

            }



            $godovoiLiquid=$godovoiLiquid+$liquid;
            $godovoiOil=$godovoiOil+$oil;
            $godovoiEmpper=$godovoiEmpper+$empper;
            $godovoiWorkday=$godovoiWorkday+$workday;
            $godovoiPrs=$godovoiPrs+$prs;
            $godovoiNdo=$godovoiNdo+$exportsResultsTotal+$insideResultsTotal;
            $godovoiDohod=$godovoiDohod+$exportsDiscontResultsTotal+$insideDiscontResultsTotal;
            $godovoiNdnpi=$godovoiNdnpi+$exportsNdpiResultsTotal+$insideNdpiResultsTotal;
            $godovoiRent=$godovoiRent+$exportsRentTaxResultsTotal;
            $godovoiEtp=$godovoiEtp+$exportsEtpResultsTotal;
            $godovoiTrans=$godovoiTrans+$exportsTarTnResultsTotal+$insideTarTnResultsTotal;
            $godovoiZatrElectrShgn=$godovoiZatrElectrShgn+$zatrElectResults[1];
            $godovoiZatrElectrEcn=$godovoiZatrElectrEcn+$zatrElectResults[2];
            $godovoiZatrPrep=$godovoiZatrPrep+array_sum($zatrPrepResults);
            $godovoiZatrPrs=$godovoiZatrPrs+array_sum($prsCostResults);
            $godovoiZatrSutObs=$godovoiZatrSutObs+$expDayResults[1];
            $godovoiArenda=$godovoiArenda+$rentCostResult;
            $godovoiAmortizacia=$godovoiAmortizacia+$amortizaciyaResult;
            $godovoiOperPryb=$godovoiOperPryb+array_sum($operPrib);
            $godovoiKpn= $godovoiKpn+array_sum($kpnResult);
            $godovoiChistPryb=$godovoiChistPryb+array_sum($chistayaPribyl);
            $godovoiKvl=$godovoiKvl+$buyCostResult;
            $godovoiSvobPot=$godovoiSvobPot+array_sum($svobodDenPotok);
            $godovoiShgnParam=$godovoiShgnParam+$shgnParam*$qZhidkosti*$workday;
            $godovoiEcnParam=$godovoiEcnParam+$ecnParam*$qZhidkosti*$workday;

            $nakoplSvobPotok=$nakoplSvobPotok+$svobodDenPotok[5];
            $discSvobPotok=$discSvobPotok+$nakoplSvobPotok;
            $nakopDiscSvodPotok=$nakopDiscSvodPotok+$discSvobPotok;
            $npv=$npv+array_sum($svobodDenPotok);

            $vdata2=[
                'last'=>$lastDateOfMonth,
                'day'=>$day,
                'year'=>$year,
                'monthname'=>$monthname,
                'liquid' => $liquid,
                'oil' => $oil,
                'empper' => $empper,
                'workday'=>$workday,
                'prs'=>array_sum($prsResult)/12,
                'srednii'=>$avgprsday->avg_prs,
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
                'prsCostResults' => $prsCostResults,
                'expDayResults' => $expDayResults,
                'rentCostResult' => $rentCostResult,
                'amortizaciyaResult' => $amortizaciyaResult,
                'operPrib' => $operPrib,
                'kpnResult' => $kpnResult,
                'chistayaPribyl' => $chistayaPribyl,
                'buyCostResult' => $buyCostResult,
                'svobodDenPotok' => $svobodDenPotok,
                'npv'=>$npv,
                'shgnParam'=>$shgnParam*$qZhidkosti*$workday,
                'ecnParam'=>$ecnParam*$qZhidkosti*$workday,
            ];

            array_push($result2,$vdata2);
        }

        $godovoi=[

            'liquid' => $godovoiLiquid,
            'oil' => $godovoiOil,
            'empper' => $godovoiEmpper,
            'workday'=>$godovoiWorkday,
            'kolichestvoPrs'=>array_sum($prsResult),
            'sredniiPrs'=>$avgprsday->avg_prs,
            'godovoiNdo'=>$godovoiNdo,
            'godovoiDohod'=>$godovoiDohod,
            'godovoiNdpi'=>$godovoiNdnpi,
            'godovoiRent'=>$godovoiRent,
            'godovoiEtp'=>$godovoiEtp,
            'godovoiTrans'=>$godovoiTrans,
            'godovoiZatrElectShgn'=>$godovoiZatrElectrShgn,
            'godovoiZatrElectEcn'=>$godovoiZatrElectrEcn,
            'godovoiZatrPrep'=>$godovoiZatrPrep,
            'godovoiZatrPrs'=>$godovoiZatrPrs,
            'godovoiZatrSutObs'=>$godovoiZatrSutObs,
            'godovoiArenda'=>$godovoiArenda,

            'godovoiAmortizacia'=>$godovoiAmortizacia,
            'godovoiOperPryb'=>$godovoiOperPryb,
            'godovoiKpn'=>$godovoiKpn,
            'godovoiChistPryb'=>$godovoiChistPryb,
            'godovoiKvl'=>$godovoiKvl,
            'godovoiSvobPot'=>$godovoiSvobPot,
            'npv'=>$npv,
            'godovoiShgnParam'=>$godovoiShgnParam,
            'godovoiEcnParam'=>$godovoiEcnParam,

        ];

        array_push($result2,$godovoi);


        return response()->json($result2);



    }

}

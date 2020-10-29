<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\EcoRefsAvgMarketPrice;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsDiscontCoefBar;
use App\Models\EcoRefsEquipId;
use App\Models\EcoRefsMacro;
use App\Models\EcoRefsNdoRates;
use App\Models\EcoRefsPrepElectPrsBrigCost;
use App\Models\EcoRefsRentEquipElectServCost;
use App\Models\EcoRefsRentTax;
use App\Models\EcoRefsRoutesId;
use App\Models\EcoRefsServiceTime;
use App\Models\EcoRefsTarifyTn;
use App\Models\Refs\EcoRefsEmpPer;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Exporter;

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
        $liquid = $request->liquid;
        $oil = $request->oil;
        $workday = $request->workday;
        $prs = $request->prs;
        $avgprs = $request->avgprs;
        $org = $request->org;
        $equipIdRequest = $request->equip;
        $serviceTime = $request->time;
        $qZhidkosti = $request->qzh;
        $shgnParam = $request->shgn;
        $ecnParam = $request->ecn;
        // Raspredelenie po napravleniyam realizacii NDO
        // To do
        $perreal = EcoRefsEmpPer::where('company_id', '=', $org)->first();
        $empper = $oil - $oil * $perreal->emp_per;

        // ------------------------NDO podschet po marshrutam
        // Export BEGIN
        $directionExp = EcoRefsDirectionId::where('name','=','Экспорт')->get();
        $exports = [];

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


        $emppersExp = EcoRefsEmpPer::whereIn('direction_id',$exports)->get();
        $discontExp = EcoRefsDiscontCoefBar::whereIn('direction_id',$exports)->get();
        $compRas = EcoRefsPrepElectPrsBrigCost::whereIn('company_id',$company)->get();
        $equipRas = EcoRefsRentEquipElectServCost::whereIn('equip_id',$equip)->get();

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

        foreach($emppersExp as $item){
            $exportsResults[$item->route_id] = $empper * $item->emp_per;
        }
        $exportsResultsTotal = array_sum($exportsResults);

        foreach($compRas as $item){
            $zatrPrepResults[$item->company_id] = $liquid * $item->trans_prep_cost;
        }

        foreach($equipRas as $item){
            $electCost = EcoRefsPrepElectPrsBrigCost::where('company_id', '=', $item->company_id)->first();
            if($item->equip_id == 1){
                $zatrElectResults[$item->equip_id] = $workday * $qZhidkosti * $shgnParam * $electCost->elect_cost;
            }
            else{
                $zatrElectResults[$item->equip_id] = $workday * $qZhidkosti * $ecnParam * $electCost->elect_cost;
            }
        }

        foreach($compRas as $item){
            $prsCostResults[$item->company_id] = $prs * $avgprs * $item->prs_brigade_cost;
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
            $rentCostResult = $buyCost->rent_cost;
        }


        $buyCostResult = 0;

        if($equipIdRequest == 1){
            $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $equipIdRequest)->first();
            $buyCostResult = $buyCost->equip_cost;
        }
        else{
            $buyCost = EcoRefsRentEquipElectServCost::where('equip_id', '=', $equipIdRequest)->first();
            $buyCostResult = 0;
        }



        // TO DO
        foreach($exportsResults as $key => $value){
            $tarifTnExp = EcoRefsTarifyTn::where('route_id','=',$key)->get();
            $tarifTnItemValue = 0;
            foreach($tarifTnExp as $row){
                if ($row->exc_id == 1){
                    $tarifTnItemValue += $value * $row->tn_rate;
                }elseif($row->exc_id == 2){
                    $rate = EcoRefsMacro::first();
                    $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_dol;
                }else{
                    $rate = EcoRefsMacro::first();
                    $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_rub;
                }
            }
            $exportsTarTnResults[$key] = $tarifTnItemValue;
        }

        $exportsTarTnResultsTotal = array_sum($exportsTarTnResults);

        foreach($discontExp as $item){
            $rate = EcoRefsMacro::where('date','=',$item->date)->first();
            $exportsDiscontResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * (($item->macro - $item->discont)*$rate->ex_rate_dol);
        }
        $exportsDiscontResultsTotal = array_sum($exportsDiscontResults);

        // To DO
        foreach($discontExp as $item){
            $rate = EcoRefsMacro::where('date','=',$item->date)->first();
            $stavki = EcoRefsNdoRates::where('company_id','=',$item->company_id)->first();
            $exportsNdpiResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rate->ex_rate_dol * $stavki->ndo_rates;
        }

        $exportsNdpiResultsTotal = array_sum($exportsNdpiResults);

        foreach($discontExp as $item){
            $rate = EcoRefsMacro::where('date','=',$item->date)->first();
            $rent = EcoRefsRentTax::where('world_price_beg','<',$item->macro)->where('world_price_end','<=',$item->macro)->first();
            $exportsRentTaxResults[$item->route_id] = $exportsResults[$item->route_id] * $item->barr_coef * $item->macro * $rate->ex_rate_dol * $rent->rate;
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
            $stavki = EcoRefsNdoRates::where('company_id','=',$item->company_id)->first();
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
                    $rate = EcoRefsMacro::first();
                    $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_dol;
                }else{
                    $rate = EcoRefsMacro::first();
                    $tarifTnItemValue += $value * $row->tn_rate * $rate->ex_rate_rub;
                }
            }
            $insideTarTnResults[$key] = $tarifTnItemValue;
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

        array_push($result,$empper);                        // 0    % OT DOBYCHI NA REALIZACIYA
        array_push($result,$exportsResultsTotal);           // 1    % OT DOBYCHI NA REALIZACIYA --- EXPORT TOTAL
        array_push($result,$exportsResults);                // 2    % OT DOBYCHI NA REALIZACIYA ----- EXPORT
        array_push($result,$insideResultsTotal);            // 3    % OT DOBYCHI NA REALIZACIYA  ------ VNUTR RYNOK TOTAL
        array_push($result,$insideResults);                 // 4    % OT DOBYCHI NA REALIZACIYA ----- VNUTR RYNOK
        array_push($result,$exportsDiscontResultsTotal);    // 5    OPREDELENIE DOHODNOY CHASTI ----- EXPORT TOTAL
        array_push($result,$exportsDiscontResults);         // 6    OPREDELENIE DOHODNOY CHASTI ----- EXPORT
        array_push($result,$insideDiscontResultsTotal);     // 7    OPREDELENIE DOHODNOY CHASTI ----- VNUTR RYNOK TOTAL
        array_push($result,$insideDiscontResults);          // 8    OPREDELENIE DOHODNOY CHASTI ----- VNUTR RYNOK
        array_push($result,$exportsNdpiResultsTotal);       // 9    RASCHET NDPI ----- EXPORT TOTAL
        array_push($result,$exportsNdpiResults);            // 10   RASCHET NDPI ----- EXPORT
        array_push($result,$insideNdpiResultsTotal);        // 11   RASCHET NDPI ----- VNUTR RYNOK TOTAL
        array_push($result,$insideNdpiResults);             // 12   RASCHET NDPI ----- VNUTR RYNOK
        array_push($result,$exportsRentTaxResultsTotal);    // 13   RASCHET RENTNOGO NALOGA ----- TOTAL
        array_push($result,$exportsRentTaxResults);         // 14   RASCHET RENTNOGO NALOGA ----- TUT TOLKO EXPORT
        array_push($result,$exportsEtpResultsTotal);        // 15   RASCHE ETP ----- TOTAL
        array_push($result,$exportsEtpResults);             // 16   RASCHET ETP ------ TUT TOLKO EXPORT
        array_push($result,$exportsTarTnResultsTotal);      // 17   RASCHET RASHODOV PO TRANSPORTIROVKE NEFTI ----- EXPORT TOTAL
        array_push($result,$exportsTarTnResults);           // 18   RASCHET RASHODOV PO TRANSPORTIROVKE NEFTI ----- EXPORT
        array_push($result,$insideTarTnResultsTotal);       // 19   RASCHET RASHODOV PO TRANSPORTIROVKE NEFTI ----- VNUTR RYNOK TOTAL
        array_push($result,$insideTarTnResults);            // 20   RASCHET RASHODOV PO TRANSPORTIROVKE NEFTI ----- VNUTR RYNOK
        array_push($result,$zatrElectResults);              // 21   ZATRATY NA ELECTOENERGIYU
        array_push($result,$zatrPrepResults);               // 22   ZATRATY NA PODGOTOVKU
        array_push($result,$prsCostResults);                // 23   ZATRATY NA PRS
        array_push($result,$expDayResults);                 // 24   ZATRATY ZA SUTOCHNOE OBSLUZHIVANIE
        array_push($result,$rentCostResult);                // 25   STOIMOST ARENDY OBORUDOVANIYA
        array_push($result,$amortizaciyaResult);            // 26   AMORTIZACIYA
        array_push($result,$operPrib);                      // 27   OPERACIONNAYA PRIBYL
        array_push($result,$kpnResult);                     // 28   KPN
        array_push($result,$chistayaPribyl);                // 29   CHISTAYA PRIBYL
        array_push($result,$buyCostResult);                 // 30   KVL (STOIMOST OBORUDOVANIYA)
        array_push($result,$svobodDenPotok);                // 31   SVOBODNYI DENEZHNYI POTOK

        return $result;

    }

}

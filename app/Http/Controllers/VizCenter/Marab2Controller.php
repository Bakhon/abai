<?php

namespace App\Http\Controllers\VizCenter;

use Illuminate\Http\Request;
use App\Models\VizCenter\Marab1;
use App\Models\VizCenter\Marab2;
use App\Models\VizCenter\Marab345;
use App\Models\VizCenter\Marab6;
use App\Models\VizCenter\Abd12;
use App\Models\VizCenter\Abd35;
use App\Models\VizCenter\Abd46;
use App\Models\VizCenter\TypeId;
use App\Models\EcoRefsCompaniesId;
use App\Http\Controllers\Controller;

class Marab2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marab2 = Marab2::latest()->with('type')->paginate(5); 
        $marab2 = Marab2::latest()->with('company')->paginate(5); 

        return view('marab2.index',compact('marab2'))
            ->with('i', (request()->input('page', 1) - 1) * 5); 
       //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = EcoRefsCompaniesId::get();
        $type = TypeId::get();
        return view('marab2.create',compact('company', 'type'));
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
            'company_id' => 'required',
            'type_id' => 'required',
            'date_col' => 'required',
            'dividends' => 'required',
            'vklad_v_ustavnoy_kapital' => 'required',
            'vydacha_zaimov' => 'required',
            'vozvrat_zaimov' => 'required',
            'vozvrat_ustavnogo_kapitala' => 'required',
            'others' => 'required',
            ]);

            Marab2::create($request->all());


        return redirect()->route('marab2.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Marab2::find($id);
        $company = EcoRefsCompaniesId::get();
        $type = TypeId::get();
        return view('marab2.edit',compact('row', 'company', 'type'));
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
        $marab2=Marab2::find($id);
        $request->validate([
            'company_id' => 'required',
            'type_id' => 'required',
            'date_col' => 'required',
            'dividends' => 'required',
            'vklad_v_ustavnoy_kapital' => 'required',
            'vydacha_zaimov' => 'required',
            'vozvrat_zaimov' => 'required',
            'vozvrat_ustavnogo_kapitala' => 'required',
            'others' => 'required',
        ]);

        $marab2->update($request->all());

        return redirect()->route('marab2.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Marab2::find($id);
        $row->delete();

        return redirect()->route('marab2.index')->with('success',__('app.deleted'));
    }

    public function kpicalculation(Request $request)
    {
        $result = [];
        
        $corp1weight = 0.2;
        $corp2weight = 0.25;
        $corp3weight = 0.2;
        $corp4weight = 0.15;
        $corp5weight = 0.1;
        $corp6weight = 0.1;

        $marab1weight = 0.2;
        $marab2weight = 0.2;
        $marab3weight = 0.2;
        $marab4weight = 0.2;
        $marab5weight = 0.15;
        $marab6weight = 0.05;

        $abd1weight = 0.2;
        $abd2weight = 0.2;
        $abd3weight = 0.1;
        $abd4weight = 0.25;
        $abd5weight = 0.2;
        $abd6weight = 0.05;

        function divideToType($InputArray) {
            $porogArray = [];
            $aimArray = [];
            $vyzovArray = [];
            $factArray = [];
            $TotalArray = [];
            foreach($InputArray as $item){
                if ($item[0] == 1){
                    array_push($porogArray, $item);
                }
                else if($item[0] == 2){
                    array_push($aimArray, $item);
                }
                else if($item[0] == 3){
                    array_push($vyzovArray, $item);
                }
                else if($item[0] == 4){
                    array_push($factArray, $item);
                }
            }
            array_push($TotalArray, $porogArray, $aimArray, $vyzovArray, $factArray);
            return $TotalArray;
        }

        function TypeSum($InputArray) {
            $TypeSumArray = [];
            foreach($InputArray as $item){
                $month = date("m",strtotime($item[1]));
                if (array_key_exists($month,$TypeSumArray)){
                    $TypeSumArray[$month] = array($TypeSumArray[$month], $item[2]);
                }
                else{
                    $TypeSumArray[$month] = $item[2];  
                }
            }
            return $TypeSumArray;
        }
        #Marabayev1 total
        $companyId = EcoRefsCompaniesId::get();
        $company = [];
        foreach($companyId as $item){
            array_push($company,$item->id);
        }

        // $categoryTotal = [];
        // $MarabTotalArray = [];
        // $marabayev_1 = Marabayev_1::whereIn('company_id',$company)->get();
        // foreach($marabayev_1 as $item){
        //     $categoryTotal[$item->company_id] = $item->A_category + $item->B_category + $item->C1_category;
        //     array_push($MarabTotalArray, $item->type_id, $categoryTotal[$item->company_id]);
        // }

        #Marabayev 1-5 calculations
        #Marabayev 1 calculations
        // $marab1Total = [];
        // $marab1TotalArray = [];
        // $marab1TempArr = [];
        // $marab1 = Marabayev_1::whereIn('company_id',$company)->get();
        // foreach($marab1 as $item){
        //     $marab1Total[$item->company_id]= $item->dividends + $item->vklad_v_ustavnoy_kapital + $item->vydacha_zaimov + $item->vozvrat_zaimov + $item->vozvrat_ustavnogo_kapitala + $item->others;
        //     // $factorTotal = array_push($factorTotal[$item->company_id]
        //     array_push($factorTempArr, $item->company_id, $item->date_col, $item->type_id, $factorTotal[$item->company_id]); #Сумма: $TempArr[3]
        //     array_push($factorTotalArray, $factorTempArr);
        //     $factorTempArr = [];
        // }
        
        #Marabayev1 calculations
        $Marab1Total = [];
        $Marab1TotalArray = [];
        $Marab1TempArr = [];
        $marabayev_1 = Marab1::whereIn('company_id',$company)->get();
        foreach($marabayev_1 as $item){
            $Marab1Total[$item->company_id] = $item->A_category + $item->B_category + $item->C1_category;
            array_push($Marab1TempArr, $item->type_id, $item->company_id, $item->date_col, $Marab1Total[$item->company_id]);
            array_push($Marab1TotalArray, $Marab1TempArr);
            $Marab1TempArr = [];
        }

        $aimArray = divideToType($Marab1TotalArray)[1];
        $factArray = divideToType($Marab1TotalArray)[3];

        $marabayev1Calculations = [];
        $deviationTotal = 0;
        foreach($factArray as $item){
            foreach($aimArray as $item2){
                if ($item[1]==$item2[1] && $item[2]==$item2[2]){
                    array_push($marabayev1Calculations, [ $item[1], $item[2], $item[3]-$item2[3], ($item[3]-$item2[3])/$item2[3]]);
                    $deviationTotal += $item[3]-$item2[3];
                }
            }
        }
        $newmarabayev1Calculations = [];
        foreach($marabayev1Calculations as $item){
            array_push($newmarabayev1Calculations, [$item[0], $item[1], $item[2], $item[3], $item[2]/$deviationTotal]);
        }

        #Factor Analysis (Marabayev 2) calculations
        $factorTotal = [];
        $factorTotalArray = [];
        $factortype = [];
        $factorTempArr = [];
        $factoranalysis = Marab2::whereIn('company_id',$company)->get();
        foreach($factoranalysis as $item){
            $factorTotal[$item->company_id]= $item->dividends + $item->vklad_v_ustavnoy_kapital + $item->vydacha_zaimov + $item->vozvrat_zaimov + $item->vozvrat_ustavnogo_kapitala + $item->others;
            // $factorTotal = array_push($factorTotal[$item->company_id]
            array_push($factorTempArr,  $item->type_id, $item->company_id, $item->date_col, $factorTotal[$item->company_id]); #Сумма: $TempArr[3]
            array_push($factorTotalArray, $factorTempArr);
            $factorTempArr = [];
        }

        $aimArray = divideToType($factorTotalArray)[1];
        $factArray = divideToType($factorTotalArray)[3];
        $factoranalysisCalculations = [];
        $deviationTotal = 0;
        foreach($factArray as $item){
            foreach($aimArray as $item2){
                if ($item[1]==$item2[1] && $item[2]==$item2[2]){
                    array_push($factoranalysisCalculations, [$item[1], $item[2], $item[0], $item[3]-$item2[3], ($item[3]-$item2[3])/$item2[3]]);
                    $deviationTotal += $item[3]-$item2[3];
                }
            }
        }

        $newfactoranalysisCalculations = [];
        foreach($factoranalysisCalculations as $item){
            array_push($newfactoranalysisCalculations, [$item[0], $item[1], $item[3], $item[4], $item[3]/$deviationTotal]);
        }

        #Marabayev 3/4/5 calculations
        $Marab3Total = [];
        $Marab3TotalArray = [];
        $Marab3TempArr = [];
        $Marab4Total = [];
        $Marab4TotalArray = [];
        $Marab4TempArr = [];
        $Marab5Total = [];
        $Marab5TotalArray = [];
        $Marab5TempArr = [];
        $marabayev_345 = Marab345::whereIn('company_id',$company)->get();
        foreach($marabayev_345 as $item){
            if($item->marabkpi_id == 1){
                $Marab3Total[$item->company_id] = $item->fact_zatraty_na_sebestoimost_dobychi_nefti;
                array_push($Marab3TempArr, $item->type_id, $item->company_id, $item->date_col, $Marab3Total[$item->company_id]);
                array_push($Marab3TotalArray, $Marab3TempArr);
                $Marab3TempArr = [];
            }
            else if($item->marabkpi_id == 2){
                $Marab4Total[$item->company_id] = $item->fact_zatraty_kapitalnogo_vlozhenia;
                array_push($Marab4TempArr, $item->type_id, $item->company_id, $item->date_col, $Marab4Total[$item->company_id]);
                array_push($Marab4TotalArray, $Marab4TempArr);
                $Marab4TempArr = [];
            }
            else if($item->marabkpi_id == 3){
                $Marab5Total[$item->company_id] = $item->fact_zatraty_na_sebestoimost_dobychi_nefti + $item->fact_zatraty_kapitalnogo_vlozhenia + $item->opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov;
                array_push($Marab5TempArr, $item->type_id, $item->company_id, $item->date_col, $Marab5Total[$item->company_id]);
                array_push($Marab5TotalArray, $Marab5TempArr);
                $Marab5TempArr = [];
            }
        }

        #Marabayev3 calculation
        $aimArray = divideToType($Marab3TotalArray)[1];
        $factArray = divideToType($Marab3TotalArray)[3];
        $marab3Calculations = [];
        $deviationTotal = 0;
        foreach($factArray as $item){
            foreach($aimArray as $item2){
                if ($item[1]==$item2[1] && $item[2]==$item2[2]){
                    array_push($marab3Calculations, [$item[1], $item[2], $item[0], $item[3]-$item2[3], ($item[3]-$item2[3])/$item2[3]]);
                    $deviationTotal += $item[3]-$item2[3];
                }
            }
        }

        $newmarab3Calculations = [];
        foreach($marab3Calculations as $item){
            array_push($newmarab3Calculations, [$item[0], $item[1], $item[3], $item[4], $item[3]/$deviationTotal]);
        }

        #Marabayev4 calculation
        $aimArray = divideToType($Marab4TotalArray)[1];
        $factArray = divideToType($Marab4TotalArray)[3];
        $marab4Calculations = [];
        $deviationTotal = 0;
        foreach($factArray as $item){
            foreach($aimArray as $item2){
                if ($item[1]==$item2[1] && $item[2]==$item2[2]){
                    array_push($marab4Calculations, [$item[1], $item[2], $item[0], $item[3]-$item2[3], ($item[3]-$item2[3])/$item2[3]]);
                    $deviationTotal += $item[3]-$item2[3];
                }
            }
        }

        $newmarab4Calculations = [];
        foreach($marab4Calculations as $item){
            array_push($newmarab4Calculations, [$item[0], $item[1], $item[3], $item[4], $item[3]/$deviationTotal]);
        }

        #Marabayev5 calculation
        $aimArray = divideToType($Marab5TotalArray)[1];
        $factArray = divideToType($Marab5TotalArray)[3];
        $marab5Calculations = [];
        $deviationTotal = 0;
        foreach($factArray as $item){
            foreach($aimArray as $item2){
                if ($item[1]==$item2[1] && $item[2]==$item2[2]){
                    array_push($marab5Calculations, [$item[1], $item[2], $item[0], $item[3]-$item2[3], ($item[3]-$item2[3])/$item2[3]]);
                    $deviationTotal += $item[3]-$item2[3];
                }
            }
        }

        $newmarab5Calculations = [];
        foreach($marab5Calculations as $item){
            array_push($newmarab5Calculations, [$item[0], $item[1], $item[3], $item[4], $item[3]/$deviationTotal]);
        }

        

        #Calculations with weights
        #Marab - 1
        $Marab1Total = [];
        $Marab1TotalArray = [];
        $Marab1TempArr = [];
        $marabayev_1 = Marab1::whereIn('company_id',$company)->get();
        foreach($marabayev_1 as $item){
            $Marab1Total[$item->company_id] = $item->A_category + $item->B_category + $item->C1_category;
            array_push($Marab1TempArr, $item->type_id, $item->date_col, $Marab1Total[$item->company_id]);
            array_push($Marab1TotalArray, $Marab1TempArr);
            $Marab1TempArr = [];
        }

        $porogArray = divideToType($Marab1TotalArray)[0];
        $aimArray = divideToType($Marab1TotalArray)[1];
        $vyzovArray = divideToType($Marab1TotalArray)[2];
        $factArray = divideToType($Marab1TotalArray)[3];
        
        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $Marabayev1Formula = [];
        foreach($porogSum as $key=>$value){
            foreach($aimSum as $key2=>$value2){
                foreach($vyzovSum as $key3=>$value3){
                    foreach($factSum as $key4=>$value4){
                        if ($key==$key2 && $key2==$key3 && $key3==$key4){
                            if (gettype($value) == "array"){
                                $porog = array_sum($value);
                            }
                            else{
                                $porog = $value;
                            }
                            if (gettype($value2) == "array"){
                                $aim = array_sum($value2);
                            }
                            else{
                                $aim = $value2;
                            }
                            if (gettype($value3) == "array"){
                                $vyzov = array_sum($value3);
                            }
                            else{
                                $vyzov = $value3;
                            }
                            if (gettype($value4) == "array"){
                                $fact = array_sum($value4);
                            }
                            else{
                                $fact = $value4;
                            }

                            if($fact<$porog){
                                array_push($Marabayev1Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $marab1weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($Marabayev1Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$marab1weight]);
                            }
                            else if($fact < $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($Marabayev1Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab1weight]);
                            }
                            else if($fact == $aim){
                                array_push($Marabayev1Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$marab1weight]);
                            }
                            else if($fact < $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($Marabayev1Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab1weight]);
                            }
                            else{
                                array_push($Marabayev1Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$marab1weight]);
                            }
                        }
                    }
                }
            }
        }
        
        #Marab - 2
        $Marab2Total = [];
        $Marab2TotalArray = [];
        $Marab2TempArr = [];
        $marabayev_2 = Marab2::whereIn('company_id',$company)->get();
        foreach($marabayev_2 as $item){
            $Marab2Total[$item->company_id] = $item->dividends + $item->vklad_v_ustavnoy_kapital + $item->vydacha_zaimov + $item->vozvrat_zaimov + $item->vozvrat_ustavnogo_kapitala + $item->others;
            array_push($Marab2TempArr, $item->type_id, $item->date_col, $Marab2Total[$item->company_id]);
            array_push($Marab2TotalArray, $Marab2TempArr);
            $Marab2TempArr = [];
        }

        $porogArray = divideToType($Marab2TotalArray)[0];
        $aimArray = divideToType($Marab2TotalArray)[1];
        $vyzovArray = divideToType($Marab2TotalArray)[2];
        $factArray = divideToType($Marab2TotalArray)[3];
        
        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $Marabayev2Formula = [];
        foreach($porogSum as $key=>$value){
            foreach($aimSum as $key2=>$value2){
                foreach($vyzovSum as $key3=>$value3){
                    foreach($factSum as $key4=>$value4){
                        if ($key==$key2 && $key2==$key3 && $key3==$key4){
                            if (gettype($value) == "array"){
                                $porog = array_sum($value);
                            }
                            else{
                                $porog = $value;
                            }
                            if (gettype($value2) == "array"){
                                $aim = array_sum($value2);
                            }
                            else{
                                $aim = $value2;
                            }
                            if (gettype($value3) == "array"){
                                $vyzov = array_sum($value3);
                            }
                            else{
                                $vyzov = $value3;
                            }
                            if (gettype($value4) == "array"){
                                $fact = array_sum($value4);
                            }
                            else{
                                $fact = $value4;
                            }

                            if($fact<$porog){
                                array_push($Marabayev2Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $marab2weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($Marabayev2Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$marab2weight]);
                            }
                            else if($fact < $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($Marabayev2Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab2weight]);
                            }
                            else if($fact == $aim){
                                array_push($Marabayev2Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$marab2weight]);
                            }
                            else if($fact < $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($Marabayev2Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab2weight]);
                            }
                            else{
                                array_push($Marabayev2Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$marab2weight]);
                            }
                        }
                    }
                }
            }
        }

        #Marab - 3/4/5
        $Marab3Total = [];
        $Marab3TotalArray = [];
        $Marab3TempArr = [];
        $Marab4Total = [];
        $Marab4TotalArray = [];
        $Marab4TempArr = [];
        $Marab5Total = [];
        $Marab5TotalArray = [];
        $Marab5TempArr = [];
        $marabayev_345 = Marab345::whereIn('company_id',$company)->get();
        foreach($marabayev_345 as $item){
            if($item->marabkpi_id == 1){
                $Marab3Total[$item->company_id] = $item->fact_zatraty_na_sebestoimost_dobychi_nefti;
                array_push($Marab3TempArr, $item->type_id, $item->date_col, $Marab3Total[$item->company_id]);
                array_push($Marab3TotalArray, $Marab3TempArr);
                $Marab3TempArr = [];
            }
            else if($item->marabkpi_id == 2){
                $Marab4Total[$item->company_id] = $item->fact_zatraty_kapitalnogo_vlozhenia;
                array_push($Marab4TempArr, $item->type_id, $item->date_col, $Marab4Total[$item->company_id]);
                array_push($Marab4TotalArray, $Marab4TempArr);
                $Marab4TempArr = [];
            }
            else if($item->marabkpi_id == 3){
                $Marab5Total[$item->company_id] = $item->fact_zatraty_na_sebestoimost_dobychi_nefti + $item->fact_zatraty_kapitalnogo_vlozhenia + $item->opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov;
                array_push($Marab5TempArr, $item->type_id, $item->date_col, $Marab5Total[$item->company_id]);
                array_push($Marab5TotalArray, $Marab5TempArr);
                $Marab5TempArr = [];
            }
        }

        $porogArray = divideToType($Marab3TotalArray)[0];
        $aimArray = divideToType($Marab3TotalArray)[1];
        $vyzovArray = divideToType($Marab3TotalArray)[2];
        $factArray = divideToType($Marab3TotalArray)[3];
        
        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $Marabayev3Formula = [];
        foreach($porogSum as $key=>$value){
            foreach($aimSum as $key2=>$value2){
                foreach($vyzovSum as $key3=>$value3){
                    foreach($factSum as $key4=>$value4){
                        if ($key==$key2 && $key2==$key3 && $key3==$key4){
                            if (gettype($value) == "array"){
                                $porog = array_sum($value);
                            }
                            else{
                                $porog = $value;
                            }
                            if (gettype($value2) == "array"){
                                $aim = array_sum($value2);
                            }
                            else{
                                $aim = $value2;
                            }
                            if (gettype($value3) == "array"){
                                $vyzov = array_sum($value3);
                            }
                            else{
                                $vyzov = $value3;
                            }
                            if (gettype($value4) == "array"){
                                $fact = array_sum($value4);
                            }
                            else{
                                $fact = $value4;
                            }

                            if($fact>$porog){
                                array_push($Marabayev3Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $marab3weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($Marabayev3Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$marab3weight]);
                            }
                            else if($fact > $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($Marabayev3Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab3weight]);
                            }
                            else if($fact == $aim){
                                array_push($Marabayev3Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$marab3weight]);
                            }
                            else if($fact > $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($Marabayev3Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab3weight]);
                            }
                            else{
                                array_push($Marabayev3Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$marab3weight]);
                            }
                        }
                    }
                }
            }
        }

        $porogArray = divideToType($Marab4TotalArray)[0];
        $aimArray = divideToType($Marab4TotalArray)[1];
        $vyzovArray = divideToType($Marab4TotalArray)[2];
        $factArray = divideToType($Marab4TotalArray)[3];
        
        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $Marabayev4Formula = [];
        foreach($porogSum as $key=>$value){
            foreach($aimSum as $key2=>$value2){
                foreach($vyzovSum as $key3=>$value3){
                    foreach($factSum as $key4=>$value4){
                        if ($key==$key2 && $key2==$key3 && $key3==$key4){
                            if (gettype($value) == "array"){
                                $porog = array_sum($value);
                            }
                            else{
                                $porog = $value;
                            }
                            if (gettype($value2) == "array"){
                                $aim = array_sum($value2);
                            }
                            else{
                                $aim = $value2;
                            }
                            if (gettype($value3) == "array"){
                                $vyzov = array_sum($value3);
                            }
                            else{
                                $vyzov = $value3;
                            }
                            if (gettype($value4) == "array"){
                                $fact = array_sum($value4);
                            }
                            else{
                                $fact = $value4;
                            }

                            if($fact>$porog){
                                array_push($Marabayev4Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $marab4weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($Marabayev4Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$marab4weight]);
                            }
                            else if($fact > $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($Marabayev4Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab4weight]);
                            }
                            else if($fact == $aim){
                                array_push($Marabayev4Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$marab4weight]);
                            }
                            else if($fact > $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($Marabayev4Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab4weight]);
                            }
                            else{
                                array_push($Marabayev4Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$marab4weight]);
                            }
                        }
                    }
                }
            }
        }

        $porogArray = divideToType($Marab5TotalArray)[0];
        $aimArray = divideToType($Marab5TotalArray)[1];
        $vyzovArray = divideToType($Marab5TotalArray)[2];
        $factArray = divideToType($Marab5TotalArray)[3];
        
        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $Marabayev5Formula = [];
        foreach($porogSum as $key=>$value){
            foreach($aimSum as $key2=>$value2){
                foreach($vyzovSum as $key3=>$value3){
                    foreach($factSum as $key4=>$value4){
                        if ($key==$key2 && $key2==$key3 && $key3==$key4){
                            if (gettype($value) == "array"){
                                $porog = array_sum($value);
                            }
                            else{
                                $porog = $value;
                            }
                            if (gettype($value2) == "array"){
                                $aim = array_sum($value2);
                            }
                            else{
                                $aim = $value2;
                            }
                            if (gettype($value3) == "array"){
                                $vyzov = array_sum($value3);
                            }
                            else{
                                $vyzov = $value3;
                            }
                            if (gettype($value4) == "array"){
                                $fact = array_sum($value4);
                            }
                            else{
                                $fact = $value4;
                            }

                            if($fact>$porog){
                                array_push($Marabayev5Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $marab5weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($Marabayev5Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$marab5weight]);
                            }
                            else if($fact > $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($Marabayev5Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab5weight]);
                            }
                            else if($fact == $aim){
                                array_push($Marabayev5Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$marab5weight]);
                            }
                            else if($fact > $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($Marabayev5Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$marab5weight]);
                            }
                            else{
                                array_push($Marabayev5Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$marab5weight]);
                            }
                        }
                    }
                }
            }
        }

        #Marab - 6
        $dateId = Marab6::get();
        $dates = [];
        foreach($dateId as $item){
            array_push($dates,$item->aim_dates);
        }
        $Marab6Total = [];
        $Marab6TotalArray = [];
        $Marab6TempArr = [];
        $marabayev_6 = Marab6::whereIn('aim_dates',$dates)->get();
        foreach($marabayev_6 as $item){
            array_push($Marab6TempArr, $item->type_id, $item->aim_dates);
            array_push($Marab6TotalArray, $Marab6TempArr);
            $Marab6TempArr = [];
        }

        $porogArray = divideToType($Marab6TotalArray)[0];
        $aimArray = divideToType($Marab6TotalArray)[1];
        $vyzovArray = divideToType($Marab6TotalArray)[2];
        $factArray = divideToType($Marab6TotalArray)[3];
        
        $Marabayev6Formula = [];
        foreach($porogArray as $item){
            foreach($aimArray as $item2){
                foreach($vyzovArray as $item3){
                    foreach($factArray as $item4){
                        $porog = date("m",strtotime($item[1]));
                        $aim = date("m",strtotime($item2[1]));
                        $vyzov = date("m",strtotime($item3[1]));
                        $fact = date("m",strtotime($item4[1]));

                        if($fact<=$porog && $fact>$aim){
                            array_push($Marabayev6Formula, [$porog, $aim, $vyzov, $fact, 50, $marab6weight*50]);
                        }
                        else if($fact <= $aim && $fact>$vyzov){
                            array_push($Marabayev6Formula, [$porog, $aim, $vyzov, $fact, 100, 100*$marab6weight]);
                        }
                        else if($fact <= $vyzov){
                            array_push($Marabayev6Formula, [$porog, $aim, $vyzov, $fact, 125, 125*$marab6weight]);
                        }
                    }
                }
            }
        }

        #Abdulgafarov - 1,2
        $dayId = Abd12::get();
        $days = [];
        foreach($dayId as $item){
            array_push($days,$item->remaining_days);
        }
        $Abd1TotalArray = [];
        $Abd1TempArr = [];
        $Abd2TotalArray = [];
        $Abd2TempArr = [];
        $abd_1 = Abd12::whereIn('remaining_days',$days)->get();
        foreach($abd_1 as $item){
            if($item->abdkpi_id == 1){
                array_push($Abd1TempArr, $item->type_id, $item->aim_params);
                array_push($Abd1TotalArray, $Abd1TempArr);
                $Abd1TempArr = [];
            }
            else if($item->abdkpi_id == 2){
                array_push($Abd2TempArr, $item->type_id, $item->aim_params);
                array_push($Abd2TotalArray, $Abd2TempArr);
                $Abd2TempArr = [];
            }
        }

        $porogArray = divideToType($Abd1TotalArray)[0];
        $aimArray = divideToType($Abd1TotalArray)[1];
        $vyzovArray = divideToType($Abd1TotalArray)[2];
        $factArray = divideToType($Abd1TotalArray)[3];
        
        $Abd1Formula = [];
        foreach($porogArray as $item){
            foreach($aimArray as $item2){
                foreach($vyzovArray as $item3){
                    foreach($factArray as $item4){
                        $porog = $item[1];
                        $aim = $item2[1];
                        $vyzov = $item3[1];
                        $fact = $item4[1];

                        if($fact<$porog){
                            array_push($Abd1Formula, [$porog, $aim, $vyzov, $fact, 0, $abd1weight*0]);
                        }
                        else if($fact == $porog){
                            array_push($Abd1Formula, [$porog, $aim, $vyzov, $fact, 50, 50*$abd1weight]);
                        }
                        else if($fact < $aim){
                            $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                            array_push($Abd1Formula, [$porog, $aim, $vyzov, $fact, $calc, $calc*$abd1weight]);
                        }
                        else if($fact == $aim){
                            array_push($Abd1Formula, [$porog, $aim, $vyzov, $fact, 100, 100*$abd1weight]);
                        }
                        else if($fact < $vyzov){
                            $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                            array_push($Abd1Formula, [$porog, $aim, $vyzov, $fact, $calc, $calc*$abd1weight]);
                        }
                        else{
                            array_push($Abd1Formula, [$porog, $aim, $vyzov, $fact, 125, 125*$abd1weight]);
                        }
                    }
                }
            }
        }

        $porogArray = divideToType($Abd2TotalArray)[0];
        $aimArray = divideToType($Abd2TotalArray)[1];
        $vyzovArray = divideToType($Abd2TotalArray)[2];
        $factArray = divideToType($Abd2TotalArray)[3];
        
        $Abd2Formula = [];
        foreach($porogArray as $item){
            foreach($aimArray as $item2){
                foreach($vyzovArray as $item3){
                    foreach($factArray as $item4){
                        $porog = $item[1];
                        $aim = $item2[1];
                        $vyzov = $item3[1];
                        $fact = $item4[1];

                        if($fact<$porog){
                            array_push($Abd2Formula, [$porog, $aim, $vyzov, $fact, 0, $abd2weight*0]);
                        }
                        else if($fact == $porog){
                            array_push($Abd2Formula, [$porog, $aim, $vyzov, $fact, 50, 50*$abd2weight]);
                        }
                        else if($fact < $aim){
                            $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                            array_push($Abd2Formula, [$porog, $aim, $vyzov, $fact, $calc, $calc*$abd2weight]);
                        }
                        else if($fact == $aim){
                            array_push($Abd2Formula, [$porog, $aim, $vyzov, $fact, 100, 100*$abd2weight]);
                        }
                        else if($fact < $vyzov){
                            $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                            array_push($Abd2Formula, [$porog, $aim, $vyzov, $fact, $calc, $calc*$abd2weight]);
                        }
                        else{
                            array_push($Abd2Formula, [$porog, $aim, $vyzov, $fact, 125, 125*$abd2weight]);
                        }
                    }
                }
            }
        }

        #Abdulgafarov - 3,5
        $dayId = Abd35::get();
        $days = [];
        foreach($dayId as $item){
            array_push($days,$item->remaining_days);
        }
        $Abd3TotalArray = [];
        $Abd3TempArr = [];
        $Abd5TotalArray = [];
        $Abd5TempArr = [];
        $abd_2 = Abd35::whereIn('remaining_days',$days)->get();
        foreach($abd_2 as $item){
            if($item->abdkpi_id == 3){
                array_push($Abd3TempArr, $item->type_id, $item->aim_params);
                array_push($Abd3TotalArray, $Abd3TempArr);
                $Abd3TempArr = [];
            }
            else if($item->abdkpi_id == 5){
                array_push($Abd5TempArr, $item->type_id, $item->aim_params);
                array_push($Abd5TotalArray, $Abd5TempArr);
                $Abd5TempArr = [];
            }
        }

        $porogArray = divideToType($Abd3TotalArray)[0];
        $aimArray = divideToType($Abd3TotalArray)[1];
        $vyzovArray = divideToType($Abd3TotalArray)[2];
        $factArray = divideToType($Abd3TotalArray)[3];
        
        $Abd3Formula = [];
        foreach($porogArray as $item){
            foreach($aimArray as $item2){
                foreach($vyzovArray as $item3){
                    foreach($factArray as $item4){
                        $porog = $item[1];
                        $aim = $item2[1];
                        $vyzov = $item3[1];
                        $fact = $item4[1];

                        if($fact<$porog){
                            array_push($Abd3Formula, [$porog, $aim, $vyzov, $fact, 0, $abd3weight*0]);
                        }
                        else if($fact == $porog){
                            array_push($Abd3Formula, [$porog, $aim, $vyzov, $fact, 50, 50*$abd3weight]);
                        }
                        else if($fact < $aim){
                            $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                            array_push($Abd3Formula, [$porog, $aim, $vyzov, $fact, $calc, $calc*$abd3weight]);
                        }
                        else if($fact == $aim){
                            array_push($Abd3Formula, [$porog, $aim, $vyzov, $fact, 100, 100*$abd3weight]);
                        }
                        else if($fact < $vyzov){
                            $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                            array_push($Abd3Formula, [$porog, $aim, $vyzov, $fact, $calc, $calc*$abd3weight]);
                        }
                        else{
                            array_push($Abd3Formula, [$porog, $aim, $vyzov, $fact, 125, 125*$abd3weight]);
                        }
                    }
                }
            }
        }

        $porogArray = divideToType($Abd5TotalArray)[0];
        $aimArray = divideToType($Abd5TotalArray)[1];
        $vyzovArray = divideToType($Abd5TotalArray)[2];
        $factArray = divideToType($Abd5TotalArray)[3];
        
        $Abd5Formula = [];
        foreach($porogArray as $item){
            foreach($aimArray as $item2){
                foreach($vyzovArray as $item3){
                    foreach($factArray as $item4){
                        $porog = $item[1];
                        $aim = $item2[1];
                        $vyzov = $item3[1];
                        $fact = $item4[1];

                        if($fact<$porog){
                            array_push($Abd5Formula, [$porog, $aim, $vyzov, $fact, 0, $abd5weight*0]);
                        }
                        else if($fact == $porog){
                            array_push($Abd5Formula, [$porog, $aim, $vyzov, $fact, 50, 50*$abd5weight]);
                        }
                        else if($fact < $aim){
                            $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                            array_push($Abd5Formula, [$porog, $aim, $vyzov, $fact, $calc, $calc*$abd5weight]);
                        }
                        else if($fact == $aim){
                            array_push($Abd5Formula, [$porog, $aim, $vyzov, $fact, 100, 100*$abd5weight]);
                        }
                        else if($fact < $vyzov){
                            $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                            array_push($Abd5Formula, [$porog, $aim, $vyzov, $fact, $calc, $calc*$abd5weight]);
                        }
                        else{
                            array_push($Abd5Formula, [$porog, $aim, $vyzov, $fact, 125, 125*$abd5weight]);
                        }
                    }
                }
            }
        }

        #Abdulgafarov - 4,6
        $dateId = Abd46::get();
        $dates = [];
        foreach($dateId as $item){
            array_push($dates,$item->remaining_days);
        }
        $Abd4TotalArray = [];
        $Abd4TempArr = [];
        $Abd6TotalArray = [];
        $Abd6TempArr = [];
        $abd_3 = Abd46::whereIn('remaining_days',$dates)->get();
        foreach($abd_3 as $item){
            if($item->abdkpi_id == 4){
                array_push($Abd4TempArr, $item->type_id, $item->aim_params);
                array_push($Abd4TotalArray, $Abd4TempArr);
                $Abd4TempArr = [];
            }
            else if($item->abdkpi_id == 6){
                array_push($Abd6TempArr, $item->type_id, $item->aim_params);
                array_push($Abd6TotalArray, $Abd6TempArr);
                $Abd6TempArr = [];
            }
        }

        $porogArray = divideToType($Abd4TotalArray)[0];
        $aimArray = divideToType($Abd4TotalArray)[1];
        $vyzovArray = divideToType($Abd4TotalArray)[2];
        $factArray = divideToType($Abd4TotalArray)[3];
        
        $Abd4Formula = [];
        foreach($porogArray as $item){
            foreach($aimArray as $item2){
                foreach($vyzovArray as $item3){
                    foreach($factArray as $item4){
                        $porog = date("m",strtotime($item[1]));
                        $aim = date("m",strtotime($item2[1]));
                        $vyzov = date("m",strtotime($item3[1]));
                        $fact = date("m",strtotime($item4[1]));

                        if($fact<=$porog && $fact>$aim){
                            array_push($Abd4Formula, [$porog, $aim, $vyzov, $fact, 50, $abd4weight*50]);
                        }
                        else if($fact <= $aim && $fact>$vyzov){
                            array_push($Abd4Formula, [$porog, $aim, $vyzov, $fact, 100, 100*$abd4weight]);
                        }
                        else if($fact <= $vyzov){
                            array_push($Abd4Formula, [$porog, $aim, $vyzov, $fact, 125, 125*$abd4weight]);
                        }
                    }
                }
            }
        }

        $porogArray = divideToType($Abd6TotalArray)[0];
        $aimArray = divideToType($Abd6TotalArray)[1];
        $vyzovArray = divideToType($Abd6TotalArray)[2];
        $factArray = divideToType($Abd6TotalArray)[3];
        
        $Abd6Formula = [];
        foreach($porogArray as $item){
            foreach($aimArray as $item2){
                foreach($vyzovArray as $item3){
                    foreach($factArray as $item4){
                        $porog = date("m",strtotime($item[1]));
                        $aim = date("m",strtotime($item2[1]));
                        $vyzov = date("m",strtotime($item3[1]));
                        $fact = date("m",strtotime($item4[1]));

                        if($fact<=$porog && $fact>$aim){
                            array_push($Abd6Formula, [$porog, $aim, $vyzov, $fact, 50, $abd6weight*50]);
                        }
                        else if($fact <= $aim && $fact>$vyzov){
                            array_push($Abd6Formula, [$porog, $aim, $vyzov, $fact, 100, 100*$abd6weight]);
                        }
                        else if($fact <= $vyzov){
                            array_push($Abd6Formula, [$porog, $aim, $vyzov, $fact, 125, 125*$abd6weight]);
                        }
                    }
                }
            }
        }

        #Results
        $result['Marabayev1(company_id; date; otklonenie ot tseli; otklonenie ot tseli %; vlianie na uluchshenie-uhudshenie)'] = $newmarabayev1Calculations; #/kpicalc
        $result['Marabayev2(company_id; date; otklonenie ot tseli; otklonenie ot tseli %; vlianie na uluchshenie-uhudshenie)'] = $newfactoranalysisCalculations; #/kpicalc
        $result['Marabayev3(company_id; date; otklonenie ot tseli; otklonenie ot tseli %; vlianie na uluchshenie-uhudshenie)'] = $newmarab3Calculations; #/kpicalc
        $result['Marabayev4(company_id; date; otklonenie ot tseli; otklonenie ot tseli %; vlianie na uluchshenie-uhudshenie)'] = $newmarab4Calculations; #/kpicalc
        $result['Marabayev5(company_id; date; otklonenie ot tseli; otklonenie ot tseli %; vlianie na uluchshenie-uhudshenie)'] = $newmarab5Calculations; #/kpicalc
        
        $result['Marabayev1(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Marabayev1Formula; #/kpicalc
        $result['Marabayev2(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Marabayev2Formula; #/kpicalc
        $result['Marabayev3(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Marabayev3Formula; #/kpicalc
        $result['Marabayev4(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Marabayev4Formula; #/kpicalc
        $result['Marabayev5(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Marabayev5Formula; #/kpicalc
        $result['Marabayev6(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Marabayev6Formula; #/kpicalc

        $result['Abdulgafarov1(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Abd1Formula; #/kpicalc
        $result['Abdulgafarov2(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Abd2Formula; #/kpicalc
        $result['Abdulgafarov3(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Abd3Formula; #/kpicalc
        $result['Abdulgafarov4(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Abd4Formula; #/kpicalc
        $result['Abdulgafarov5(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Abd5Formula; #/kpicalc
        $result['Abdulgafarov6(month_number; porog; tsel; vyzov; fact; formula1; formula2)'] = $Abd6Formula; #/kpicalc

        #Марабаев 1 - /marab1
        #Марабаев 2 - /marab2
        #Марабаев 3 - /marab345
        #Марабаев 4 - /marab345
        #Марабаев 5 - /marab345
        #Марабаев 6 - /marab6

        #Абдулгафаров 1 - /abd12
        #Абдулгафаров 2 - /abd12
        #Абдулгафаров 3 - /abd35
        #Абдулгафаров 4 - /abd46
        #Абдулгафаров 5 - /abd35
        #Абдулгафаров 6 - /abd46
        return $result;
        }
}

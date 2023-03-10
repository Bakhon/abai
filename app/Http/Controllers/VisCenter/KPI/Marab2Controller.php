<?php

namespace App\Http\Controllers\VisCenter\KPI;

use Illuminate\Http\Request;
use App\Models\VisCenter\KPI\Marab1;
use App\Models\VisCenter\KPI\Marab2;
use App\Models\VisCenter\KPI\Marab345;
use App\Models\VisCenter\KPI\Marab6;
use App\Models\VisCenter\KPI\Abd12;
use App\Models\VisCenter\KPI\Abd35;
use App\Models\VisCenter\KPI\Abd46;
use App\Models\VisCenter\KPI\TypeId;
use App\Models\VisCenter\KPI\CorpAll;
use App\Models\EcoRefsCompaniesId;
use App\Http\Controllers\Controller;

class Marab2Controller extends Controller
{
    /**
     * Константы типов данных
     */
    const POROG_TYPE_ID = 1;

    const AIM_TYPE_ID = 2;

    const VIZOV_TYPE_ID = 3;

    const FACT_TYPE_ID = 4;

    /**
     * @var array
     */
    protected static $companyNames;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marab2 = Marab2::latest()->with('type')->paginate(5); 
        $marab2 = Marab2::latest()->with('company')->paginate(5); 

        return view('viscenterKPI.marab2.index',compact('marab2'))
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
        return view('viscenterKPI.marab2.create',compact('company', 'type'));
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
            'date' => 'required',
            // 'dividends' => 'required',
            // 'vklad_v_ustavnoy_kapital' => 'required',
            // 'vydacha_zaimov' => 'required',
            // 'vozvrat_zaimov' => 'required',
            // 'vozvrat_ustavnogo_kapitala' => 'required',
            // 'others' => 'required',
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
        return view('viscenterKPI.marab2.edit',compact('row', 'company', 'type'));
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
            'date' => 'required',
            // 'dividends' => 'required',
            // 'vklad_v_ustavnoy_kapital' => 'required',
            // 'vydacha_zaimov' => 'required',
            // 'vozvrat_zaimov' => 'required',
            // 'vozvrat_ustavnogo_kapitala' => 'required',
            // 'others' => 'required',
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

    public function kpiList(){
        return view('viscenterKPI.marab2.list');
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

        function TypeSum($InputArray) {
            $TypeSumArray = [];
            foreach($InputArray as $item){
                $month = date("m",strtotime($item[1]));
                $TypeSumArray[$month][] = $item[2];
            }
            return $TypeSumArray;
        }
        #Marabayev1 total
        $companyId = EcoRefsCompaniesId::get();
        $company = [];
        foreach($companyId as $item){
            self::$companyNames[$item->id] = $item->name;
            array_push($company,$item->id);
        }

        #Marabayev1 calculations
        $Marab1Total = [];
        $Marab1TotalArray = [];
        $Marab1TempArr = [];
        $marabayev_1 = Marab1::whereIn('company_id',$company)->get();
        foreach($marabayev_1 as $item){
            $Marab1Total[$item->company_id] = $item->A_category + $item->B_category + $item->C1_category;
            array_push($Marab1TempArr, $item->type_id, $item->company_id, $item->date, $Marab1Total[$item->company_id]);
            array_push($Marab1TotalArray, $Marab1TempArr);
            $Marab1TempArr = [];
        }

        $newmarabayev1Calculations = $this->compileMarabData($Marab1TotalArray);

        #Factor Analysis (Marabayev 2) calculations
        $factorTotal = [];
        $factorTotalArray = [];
        $factorTempArr = [];
        $factoranalysis = Marab2::whereIn('company_id',$company)->get();
        foreach($factoranalysis as $item){
            $factorTotal[$item->company_id]= $item->dividends + $item->vklad_v_ustavnoy_kapital + $item->vydacha_zaimov + $item->vozvrat_zaimov + $item->vozvrat_ustavnogo_kapitala + $item->others;
            // $factorTotal = array_push($factorTotal[$item->company_id]
            array_push($factorTempArr,  $item->type_id, $item->company_id, $item->date, $factorTotal[$item->company_id]); #Сумма: $TempArr[3]
            array_push($factorTotalArray, $factorTempArr);
            $factorTempArr = [];
        }

        $newfactoranalysisCalculations = $this->compileMarabData($factorTotalArray);

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
                array_push($Marab3TempArr, $item->type_id, $item->company_id, $item->date, $Marab3Total[$item->company_id]);
                array_push($Marab3TotalArray, $Marab3TempArr);
                $Marab3TempArr = [];
            }
            else if($item->marabkpi_id == 2){
                $Marab4Total[$item->company_id] = $item->fact_zatraty_kapitalnogo_vlozhenia;
                array_push($Marab4TempArr, $item->type_id, $item->company_id, $item->date, $Marab4Total[$item->company_id]);
                array_push($Marab4TotalArray, $Marab4TempArr);
                $Marab4TempArr = [];
            }
            else if($item->marabkpi_id == 3){
                $Marab5Total[$item->company_id] = $item->fact_zatraty_na_sebestoimost_dobychi_nefti + $item->fact_zatraty_kapitalnogo_vlozhenia + $item->opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov;
                array_push($Marab5TempArr, $item->type_id, $item->company_id, $item->date, $Marab5Total[$item->company_id]);
                array_push($Marab5TotalArray, $Marab5TempArr);
                $Marab5TempArr = [];
            }
        }


        $newmarab3Calculations = $this->compileMarabData($Marab3TotalArray);
        $newmarab4Calculations = $this->compileMarabData($Marab4TotalArray);
        $newmarab5Calculations = $this->compileMarabData($Marab5TotalArray);

        #Calculations with weights
        #Marab - 1
        $Marab1Total = [];
        $Marab1TotalArray = [];
        $Marab1TempArr = [];
        $marabayev_1 = Marab1::whereIn('company_id',$company)->get();
        foreach($marabayev_1 as $item){
            $Marab1Total[$item->company_id] = $item->A_category + $item->B_category + $item->C1_category;
            array_push($Marab1TempArr, $item->type_id, $item->date, $Marab1Total[$item->company_id]);
            array_push($Marab1TotalArray, $Marab1TempArr);
            $Marab1TempArr = [];
        }

        $porogArray = $this->divideToType($Marab1TotalArray)[0];
        $aimArray = $this->divideToType($Marab1TotalArray)[1];
        $vyzovArray = $this->divideToType($Marab1TotalArray)[2];
        $factArray = $this->divideToType($Marab1TotalArray)[3];
        
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
            array_push($Marab2TempArr, $item->type_id, $item->date, $Marab2Total[$item->company_id]);
            array_push($Marab2TotalArray, $Marab2TempArr);
            $Marab2TempArr = [];
        }

        $porogArray = $this->divideToType($Marab2TotalArray)[0];
        $aimArray = $this->divideToType($Marab2TotalArray)[1];
        $vyzovArray = $this->divideToType($Marab2TotalArray)[2];
        $factArray = $this->divideToType($Marab2TotalArray)[3];
        
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
                array_push($Marab3TempArr, $item->type_id, $item->date, $Marab3Total[$item->company_id]);
                array_push($Marab3TotalArray, $Marab3TempArr);
                $Marab3TempArr = [];
            }
            else if($item->marabkpi_id == 2){
                $Marab4Total[$item->company_id] = $item->fact_zatraty_kapitalnogo_vlozhenia;
                array_push($Marab4TempArr, $item->type_id, $item->date, $Marab4Total[$item->company_id]);
                array_push($Marab4TotalArray, $Marab4TempArr);
                $Marab4TempArr = [];
            }
            else if($item->marabkpi_id == 3){
                $Marab5Total[$item->company_id] = $item->fact_zatraty_na_sebestoimost_dobychi_nefti + $item->fact_zatraty_kapitalnogo_vlozhenia + $item->opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov;
                array_push($Marab5TempArr, $item->type_id, $item->date, $Marab5Total[$item->company_id]);
                array_push($Marab5TotalArray, $Marab5TempArr);
                $Marab5TempArr = [];
            }
        }

        $porogArray = $this->divideToType($Marab3TotalArray)[0];
        $aimArray = $this->divideToType($Marab3TotalArray)[1];
        $vyzovArray = $this->divideToType($Marab3TotalArray)[2];
        $factArray = $this->divideToType($Marab3TotalArray)[3];
        
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

        $porogArray = $this->divideToType($Marab4TotalArray)[0];
        $aimArray = $this->divideToType($Marab4TotalArray)[1];
        $vyzovArray = $this->divideToType($Marab4TotalArray)[2];
        $factArray = $this->divideToType($Marab4TotalArray)[3];
        
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

        $porogArray = $this->divideToType($Marab5TotalArray)[0];
        $aimArray = $this->divideToType($Marab5TotalArray)[1];
        $vyzovArray = $this->divideToType($Marab5TotalArray)[2];
        $factArray = $this->divideToType($Marab5TotalArray)[3];
        
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

        $porogArray = $this->divideToType($Marab6TotalArray)[0];
        $aimArray = $this->divideToType($Marab6TotalArray)[1];
        $vyzovArray = $this->divideToType($Marab6TotalArray)[2];
        $factArray = $this->divideToType($Marab6TotalArray)[3];
        
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

        $porogArray = $this->divideToType($Abd1TotalArray)[0];
        $aimArray = $this->divideToType($Abd1TotalArray)[1];
        $vyzovArray = $this->divideToType($Abd1TotalArray)[2];
        $factArray = $this->divideToType($Abd1TotalArray)[3];
        
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

        $porogArray = $this->divideToType($Abd2TotalArray)[0];
        $aimArray = $this->divideToType($Abd2TotalArray)[1];
        $vyzovArray = $this->divideToType($Abd2TotalArray)[2];
        $factArray = $this->divideToType($Abd2TotalArray)[3];
        
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

        $porogArray = $this->divideToType($Abd3TotalArray)[0];
        $aimArray = $this->divideToType($Abd3TotalArray)[1];
        $vyzovArray = $this->divideToType($Abd3TotalArray)[2];
        $factArray = $this->divideToType($Abd3TotalArray)[3];
        
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

        $porogArray = $this->divideToType($Abd5TotalArray)[0];
        $aimArray = $this->divideToType($Abd5TotalArray)[1];
        $vyzovArray = $this->divideToType($Abd5TotalArray)[2];
        $factArray = $this->divideToType($Abd5TotalArray)[3];
        
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

        $porogArray = $this->divideToType($Abd4TotalArray)[0];
        $aimArray = $this->divideToType($Abd4TotalArray)[1];
        $vyzovArray = $this->divideToType($Abd4TotalArray)[2];
        $factArray = $this->divideToType($Abd4TotalArray)[3];
        
        $Abd4Formula = [];
        foreach($porogArray as $item){
            foreach($aimArray as $item2){
                foreach($vyzovArray as $item3){
                    foreach($factArray as $item4){
                        $porog = (int)date("m",strtotime($item[1]));
                        $aim = (int)date("m",strtotime($item2[1]));
                        $vyzov = (int)date("m",strtotime($item3[1]));
                        $fact = (int)date("m",strtotime($item4[1]));

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

        $porogArray = $this->divideToType($Abd6TotalArray)[0];
        $aimArray = $this->divideToType($Abd6TotalArray)[1];
        $vyzovArray = $this->divideToType($Abd6TotalArray)[2];
        $factArray = $this->divideToType($Abd6TotalArray)[3];
        
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
        
        #Corp1 KPI
        $CorpAll1Array = [];
        $CorpAll1Arr = [];
        $corpall = CorpAll::whereIn('company_id',$company)->get();
        foreach($corpall as $item){
            if($item->corpkpi_id == 1){
                array_push($CorpAll1Arr, $item->type_id, $item->date, $item->value);
                array_push($CorpAll1Array, $CorpAll1Arr);
                $CorpAll1Arr = [];
            }
        } 

        $porogArray = $this->divideToType($CorpAll1Array)[0];
        $aimArray = $this->divideToType($CorpAll1Array)[1];
        $vyzovArray = $this->divideToType($CorpAll1Array)[2];
        $factArray = $this->divideToType($CorpAll1Array)[3];

        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $CorpAll1Formula = [];
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
                                array_push($CorpAll1Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $corp1weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($CorpAll1Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$corp1weight]);
                            }
                            else if($fact < $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($CorpAll1Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp1weight]);
                            }
                            else if($fact == $aim){
                                array_push($CorpAll1Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$corp1weight]);
                            }
                            else if($fact < $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($CorpAll1Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp1weight]);
                            }
                            else{
                                array_push($CorpAll1Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$corp1weight]);
                            }
                        }
                    }
                }
            }
        }

        #Corp2 KPI
        $CorpAll2Array = [];
        $CorpAll2Arr = [];
        $corpall = CorpAll::whereIn('company_id',$company)->get();
        foreach($corpall as $item){
            if($item->corpkpi_id == 2){
                array_push($CorpAll2Arr, $item->type_id, $item->date, $item->value);
                array_push($CorpAll2Array, $CorpAll2Arr);
                $CorpAll2Arr = [];
            }
        } 

        $porogArray = $this->divideToType($CorpAll2Array)[0];
        $aimArray = $this->divideToType($CorpAll2Array)[1];
        $vyzovArray = $this->divideToType($CorpAll2Array)[2];
        $factArray = $this->divideToType($CorpAll2Array)[3];

        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $CorpAll2Formula = [];
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
                                array_push($CorpAll2Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $corp2weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($CorpAll2Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$corp2weight]);
                            }
                            else if($fact > $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($CorpAll2Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp2weight]);
                            }
                            else if($fact == $aim){
                                array_push($CorpAll2Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$corp2weight]);
                            }
                            else if($fact > $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($CorpAll2Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp2weight]);
                            }
                            else{
                                array_push($CorpAll2Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$corp2weight]);
                            }
                        }
                    }
                }
            }
        }

        #Corp3 KPI
        $CorpAll3Array = [];
        $CorpAll3Arr = [];
        $corpall = CorpAll::whereIn('company_id',$company)->get();
        foreach($corpall as $item){
            if($item->corpkpi_id == 3){
                array_push($CorpAll3Arr, $item->type_id, $item->date, $item->value);
                array_push($CorpAll3Array, $CorpAll3Arr);
                $CorpAll3Arr = [];
            }
        } 

        $porogArray = $this->divideToType($CorpAll3Array)[0];
        $aimArray = $this->divideToType($CorpAll3Array)[1];
        $vyzovArray = $this->divideToType($CorpAll3Array)[2];
        $factArray = $this->divideToType($CorpAll3Array)[3];

        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $CorpAll3Formula = [];
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
                                array_push($CorpAll3Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $corp3weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($CorpAll3Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$corp3weight]);
                            }
                            else if($fact < $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($CorpAll3Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp3weight]);
                            }
                            else if($fact == $aim){
                                array_push($CorpAll3Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$corp3weight]);
                            }
                            else if($fact < $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($CorpAll3Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp3weight]);
                            }
                            else{
                                array_push($CorpAll3Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$corp3weight]);
                            }
                        }
                    }
                }
            }
        }

        #Corp4 KPI
        $CorpAll4Array = [];
        $CorpAll4Arr = [];
        $corpall = CorpAll::whereIn('company_id',$company)->get();
        foreach($corpall as $item){
            if($item->corpkpi_id == 4){
                array_push($CorpAll4Arr, $item->type_id, $item->date, $item->value);
                array_push($CorpAll4Array, $CorpAll4Arr);
                $CorpAll4Arr = [];
            }
        } 

        $porogArray = $this->divideToType($CorpAll4Array)[0];
        $aimArray = $this->divideToType($CorpAll4Array)[1];
        $vyzovArray = $this->divideToType($CorpAll4Array)[2];
        $factArray = $this->divideToType($CorpAll4Array)[3];

        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $CorpAll4Formula = [];
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
                                array_push($CorpAll4Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $corp4weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($CorpAll4Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$corp4weight]);
                            }
                            else if($fact < $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($CorpAll4Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp4weight]);
                            }
                            else if($fact == $aim){
                                array_push($CorpAll4Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$corp4weight]);
                            }
                            else if($fact < $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($CorpAll4Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp4weight]);
                            }
                            else{
                                array_push($CorpAll4Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$corp4weight]);
                            }
                        }
                    }
                }
            }
        }

        #Corp5 KPI
        $CorpAll5Array = [];
        $CorpAll5Arr = [];
        $corpall = CorpAll::whereIn('company_id',$company)->get();
        foreach($corpall as $item){
            if($item->corpkpi_id == 5){
                array_push($CorpAll5Arr, $item->type_id, $item->date, $item->value);
                array_push($CorpAll5Array, $CorpAll5Arr);
                $CorpAll5Arr = [];
            }
        } 

        $porogArray = $this->divideToType($CorpAll5Array)[0];
        $aimArray = $this->divideToType($CorpAll5Array)[1];
        $vyzovArray = $this->divideToType($CorpAll5Array)[2];
        $factArray = $this->divideToType($CorpAll5Array)[3];

        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $CorpAll5Formula = [];
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
                                array_push($CorpAll5Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $corp5weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($CorpAll5Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$corp5weight]);
                            }
                            else if($fact < $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($CorpAll5Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp5weight]);
                            }
                            else if($fact == $aim){
                                array_push($CorpAll5Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$corp5weight]);
                            }
                            else if($fact < $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($CorpAll5Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp5weight]);
                            }
                            else{
                                array_push($CorpAll5Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$corp5weight]);
                            }
                        }
                    }
                }
            }
        }

        #Corp4 KPI
        $CorpAll6Array = [];
        $CorpAll6Arr = [];
        $corpall = CorpAll::whereIn('company_id',$company)->get();
        foreach($corpall as $item){
            if($item->corpkpi_id == 6){
                array_push($CorpAll6Arr, $item->type_id, $item->date, $item->value);
                array_push($CorpAll6Array, $CorpAll6Arr);
                $CorpAll6Arr = [];
            }
        } 

        $porogArray = $this->divideToType($CorpAll6Array)[0];
        $aimArray = $this->divideToType($CorpAll6Array)[1];
        $vyzovArray = $this->divideToType($CorpAll6Array)[2];
        $factArray = $this->divideToType($CorpAll6Array)[3];

        $porogSum = TypeSum($porogArray);
        $aimSum = TypeSum($aimArray);
        $vyzovSum = TypeSum($vyzovArray);
        $factSum = TypeSum($factArray);
        
        $CorpAll6Formula = [];
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
                                array_push($CorpAll6Formula, [$key, $porog, $aim, $vyzov, $fact, 0, $corp4weight*0]);
                            }
                            else if($fact == $porog){
                                array_push($CorpAll6Formula, [$key, $porog, $aim, $vyzov, $fact, 50, 50*$corp6weight]);
                            }
                            else if($fact < $aim){
                                $calc = ($fact-$porog)/($aim-$porog)*50+50; 
                                array_push($CorpAll6Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp6weight]);
                            }
                            else if($fact == $aim){
                                array_push($CorpAll6Formula, [$key, $porog, $aim, $vyzov, $fact, 100, 100*$corp6weight]);
                            }
                            else if($fact < $vyzov){
                                $calc = ($fact-$aim)/($vyzov-$aim)*25+100; 
                                array_push($CorpAll6Formula, [$key, $porog, $aim, $vyzov, $fact, $calc, $calc*$corp6weight]);
                            }
                            else{
                                array_push($CorpAll6Formula, [$key, $porog, $aim, $vyzov, $fact, 125, 125*$corp6weight]);
                            }
                        }
                    }
                }
            }
        }

        #Results
        $result['Marabayev1Table'] = $newmarabayev1Calculations; #/kpicalc
        $result['Marabayev2Table'] = $newfactoranalysisCalculations; #/kpicalc
        $result['Marabayev3Table'] = $newmarab3Calculations; #/kpicalc
        $result['Marabayev4Table'] = $newmarab4Calculations; #/kpicalc
        $result['Marabayev5Table'] = $newmarab5Calculations; #/kpicalc
        
        $result['Marabayev1'] = $Marabayev1Formula; #/kpicalc
        $result['Marabayev2'] = $Marabayev2Formula; #/kpicalc
        $result['Marabayev3'] = $Marabayev3Formula; #/kpicalc
        $result['Marabayev4'] = $Marabayev4Formula; #/kpicalc
        $result['Marabayev5'] = $Marabayev5Formula; #/kpicalc
        $result['Marabayev6'] = $Marabayev6Formula; #/kpicalc

        $result['Abdulgafarov1'] = $Abd1Formula; #/kpicalc
        $result['Abdulgafarov2'] = $Abd2Formula; #/kpicalc
        $result['Abdulgafarov3'] = $Abd3Formula; #/kpicalc
        $result['Abdulgafarov4'] = $Abd4Formula; #/kpicalc
        $result['Abdulgafarov5'] = $Abd5Formula; #/kpicalc
        $result['Abdulgafarov6'] = $Abd6Formula; #/kpicalc

        $result['CorpAll1'] = $CorpAll1Formula; #/kpicalc
        $result['CorpAll2'] = $CorpAll2Formula; #/kpicalc
        $result['CorpAll3'] = $CorpAll3Formula; #/kpicalc
        $result['CorpAll4'] = $CorpAll4Formula; #/kpicalc
        $result['CorpAll5'] = $CorpAll5Formula; #/kpicalc
        $result['CorpAll6'] = $CorpAll6Formula; #/kpicalc

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

        #Корпоративные КПД - /corpall

        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    private function compileMarabData(array $data)
    {
        $tmpArray = [];
        $tmpDeviationArray = [];
        foreach ($data as $dataItem) {
            $tmpArray[$dataItem[1]][$dataItem[2]][$dataItem[0]] = $dataItem[3];
            if ($dataItem[0] == self::FACT_TYPE_ID) {
                $tmpDeviationArray[$dataItem[2]][self::FACT_TYPE_ID][] = $dataItem[3];
            }
            if ($dataItem[0] == self::AIM_TYPE_ID) {
                $tmpDeviationArray[$dataItem[2]][self::AIM_TYPE_ID][] = $dataItem[3];
            }
        }
        $resultArray = [];
        foreach ($tmpArray as $companyId => $tmpItem) {
            $lastElement = end($tmpItem);
            $porog = $lastElement[self::POROG_TYPE_ID] ?? 0;
            $aim = $lastElement[self::AIM_TYPE_ID] ?? 0;
            $vizov = $lastElement[self::VIZOV_TYPE_ID] ?? 0;
            $fact = $lastElement[self::FACT_TYPE_ID] ?? 0;
            $itemDeviation = array_sum($tmpDeviationArray[array_key_last($tmpItem)][self::FACT_TYPE_ID] ?? [])
                - array_sum($tmpDeviationArray[array_key_last($tmpItem)][self::AIM_TYPE_ID] ?? []);
            $itemDeviation = $itemDeviation ?: $fact - $aim ?: 1;
            $relativeDeviation = $aim ? ($fact - $aim) / $aim : 1;
            $effect = round(-(($fact - $aim) / $itemDeviation * 100), 2);
            $resultArray[] = [
                $porog,
                $aim,
                $vizov,
                $fact,
                self::$companyNames[$companyId],
                array_key_last($tmpItem),
                $fact - $aim,
                round($relativeDeviation * 100, 2),
                $effect,
            ];
        }
        $sumPorog = $sumAim = $sumVizov = $sumFact = $sumDeviation = $sumEffect = 0.00;
        foreach ($resultArray as $tmpItem) {
            $sumPorog += $tmpItem[0];
            $sumAim += $tmpItem[1];
            $sumVizov += $tmpItem[2];
            $sumFact += $tmpItem[3];
            $sumDeviation += $tmpItem[6];
            $sumEffect += $tmpItem[8];
        }

        return ['data' => $resultArray, 'sum' => [
            $sumPorog,
            $sumAim,
            $sumVizov,
            $sumFact,
            $sumDeviation,
            round((($sumFact - $sumAim) / $sumAim * 100), 2),
            round($sumEffect, 2),
        ]];
    }

    private function divideToType($InputArray) {
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
}

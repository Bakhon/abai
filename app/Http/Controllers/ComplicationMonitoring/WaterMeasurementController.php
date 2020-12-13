<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Models\ComplicationMonitoring\ConstantsValue;
use App\Models\ComplicationMonitoring\Corrosion as ComplicationMonitoringCorrosion;
use App\Models\ComplicationMonitoring\GuKormass as ComplicationMonitoringGuKormass;
use App\Models\ComplicationMonitoring\Kormass;
use App\Models\ComplicationMonitoring\OmgUHE as ComplicationMonitoringOmgUHE;
use App\Models\ComplicationMonitoring\Pipe;
use App\Models\ComplicationMonitoring\WaterMeasurement as ComplicationMonitoringWaterMeasurement;
use App\Models\Refs\Cdng as RefsCdng;
use App\Models\Refs\Gu as RefsGu;
use App\Models\Refs\HydrocarbonOxidizingBacteria as RefsHydrocarbonOxidizingBacteria;
use App\Models\Refs\Ngdu as RefsNgdu;
use App\Models\Refs\OtherObjects as RefsOtherObjects;
use App\Models\Refs\SulphateReducingBacteria as RefsSulphateReducingBacteria;
use App\Models\Refs\ThionicBacteria as RefsThionicBacteria;
use App\Models\Refs\WaterTypeBySulin as RefsWaterTypeBySulin;
use App\Models\Refs\Well as RefsWell;
use App\Models\Refs\Zu as RefsZu;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaterMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wm = ComplicationMonitoringWaterMeasurement::orderByDesc('date')
                                ->with('other_objects')
                                ->with('ngdu')
                                ->with('cdng')
                                ->with('gu')
                                ->with('zu')
                                ->with('well')
                                ->with('waterTypeBySulin')
                                ->with('sulphateReducingBacteria')
                                ->with('hydrocarbonOxidizingBacteria')
                                ->with('thionicBacteria')
                                ->paginate(10);



        return view('watermeasurement.index',compact('wm'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('watermeasurement.create');
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
            'date' => 'required',
        ]);

        $wm = new ComplicationMonitoringWaterMeasurement;
        $wm->other_objects_id = ($request->other_objects_id) ? $request->other_objects_id : NULL;
        $wm->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : NULL;
        $wm->cdng_id = ($request->cdng_id) ? $request->cdng_id : NULL;
        $wm->gu_id = ($request->gu_id) ? $request->gu_id : NULL;
        $wm->zu_id = ($request->zu_id) ? $request->zu_id : NULL;
        $wm->well_id = ($request->well_id) ? $request->well_id : NULL;
        $wm->date = date("Y-m-d H:i", strtotime($request->date));
        $wm->hydrocarbonate_ion = ($request->hydrocarbonate_ion) ? $request->hydrocarbonate_ion : NULL;
        $wm->carbonate_ion = ($request->carbonate_ion) ? $request->carbonate_ion : NULL;
        $wm->sulphate_ion = ($request->sulphate_ion) ? $request->sulphate_ion : NULL;
        $wm->chlorum_ion = ($request->chlorum_ion) ? $request->chlorum_ion : NULL;
        $wm->calcium_ion = ($request->calcium_ion) ? $request->calcium_ion : NULL;
        $wm->magnesium_ion = ($request->magnesium_ion) ? $request->magnesium_ion : NULL;
        $wm->potassium_ion_sodium_ion = ($request->potassium_ion_sodium_ion) ? $request->potassium_ion_sodium_ion : NULL;
        $wm->density = ($request->density) ? $request->density : NULL;
        $wm->ph = ($request->ph) ? $request->ph : NULL;
        $wm->mineralization = ($request->mineralization) ? $request->mineralization : NULL;
        $wm->total_hardness = ($request->total_hardness) ? $request->total_hardness : NULL;
        $wm->water_type_by_sulin_id = ($request->water_type_by_sulin_id) ? $request->water_type_by_sulin_id : NULL;
        $wm->content_of_petrolium_products = ($request->content_of_petrolium_products) ? $request->content_of_petrolium_products : NULL;
        $wm->mechanical_impurities = ($request->mechanical_impurities) ? $request->mechanical_impurities : NULL;
        $wm->strontium_content = ($request->strontium_content) ? $request->strontium_content : NULL;
        $wm->barium_content = ($request->barium_content) ? $request->barium_content : NULL;
        $wm->total_iron_content = ($request->total_iron_content) ? $request->total_iron_content : NULL;
        $wm->ferric_iron_content = ($request->ferric_iron_content) ? $request->ferric_iron_content : NULL;
        $wm->ferrous_iron_content = ($request->ferrous_iron_content) ? $request->ferrous_iron_content : NULL;
        $wm->hydrogen_sulfide = ($request->hydrogen_sulfide) ? $request->hydrogen_sulfide : NULL;
        $wm->oxygen = ($request->oxygen) ? $request->oxygen : NULL;
        $wm->carbon_dioxide = ($request->carbon_dioxide) ? $request->carbon_dioxide : NULL;
        $wm->sulphate_reducing_bacteria_id = ($request->sulphate_reducing_bacteria_id) ? $request->sulphate_reducing_bacteria_id : NULL;
        $wm->hydrocarbon_oxidizing_bacteria_id = ($request->hydrocarbon_oxidizing_bacteria_id) ? $request->hydrocarbon_oxidizing_bacteria_id : NULL;
        $wm->thionic_bacteria_id = ($request->thionic_bacteria_id) ? $request->thionic_bacteria_id : NULL;
        $wm->cruser_id = Auth::user()->id;
        $wm->save();

        return redirect()->route('watermeasurement.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wm = ComplicationMonitoringWaterMeasurement::where('id', '=', $id)
                            ->with('other_objects')
                            ->with('ngdu')
                            ->with('cdng')
                            ->with('gu')
                            ->with('zu')
                            ->with('well')
                            ->with('waterTypeBySulin')
                            ->with('sulphateReducingBacteria')
                            ->with('hydrocarbonOxidizingBacteria')
                            ->with('thionicBacteria')
                            ->first();

        return view('watermeasurement.show', compact('wm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ComplicationMonitoringWaterMeasurement $watermeasurement)
    {
        return view('watermeasurement.edit', compact('watermeasurement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComplicationMonitoringWaterMeasurement $watermeasurement)
    {
        $request->validate([
            'date' => 'required',
        ]);

        $watermeasurement->other_objects_id = ($request->other_objects_id) ? $request->other_objects_id : NULL;
        $watermeasurement->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : NULL;
        $watermeasurement->cdng_id = ($request->cdng_id) ? $request->cdng_id : NULL;
        $watermeasurement->gu_id = ($request->gu_id) ? $request->gu_id : NULL;
        $watermeasurement->zu_id = ($request->zu_id) ? $request->zu_id : NULL;
        $watermeasurement->well_id = ($request->well_id) ? $request->well_id : NULL;
        $watermeasurement->date = date("Y-m-d H:i", strtotime($request->date));
        $watermeasurement->hydrocarbonate_ion = ($request->hydrocarbonate_ion) ? $request->hydrocarbonate_ion : NULL;
        $watermeasurement->carbonate_ion = ($request->carbonate_ion) ? $request->carbonate_ion : NULL;
        $watermeasurement->sulphate_ion = ($request->sulphate_ion) ? $request->sulphate_ion : NULL;
        $watermeasurement->chlorum_ion = ($request->chlorum_ion) ? $request->chlorum_ion : NULL;
        $watermeasurement->calcium_ion = ($request->calcium_ion) ? $request->calcium_ion : NULL;
        $watermeasurement->magnesium_ion = ($request->magnesium_ion) ? $request->magnesium_ion : NULL;
        $watermeasurement->potassium_ion_sodium_ion = ($request->potassium_ion_sodium_ion) ? $request->potassium_ion_sodium_ion : NULL;
        $watermeasurement->density = ($request->density) ? $request->density : NULL;
        $watermeasurement->ph = ($request->ph) ? $request->ph : NULL;
        $watermeasurement->mineralization = ($request->mineralization) ? $request->mineralization : NULL;
        $watermeasurement->total_hardness = ($request->total_hardness) ? $request->total_hardness : NULL;
        $watermeasurement->water_type_by_sulin_id = ($request->water_type_by_sulin_id) ? $request->water_type_by_sulin_id : NULL;
        $watermeasurement->content_of_petrolium_products = ($request->content_of_petrolium_products) ? $request->content_of_petrolium_products : NULL;
        $watermeasurement->mechanical_impurities = ($request->mechanical_impurities) ? $request->mechanical_impurities : NULL;
        $watermeasurement->strontium_content = ($request->strontium_content) ? $request->strontium_content : NULL;
        $watermeasurement->barium_content = ($request->barium_content) ? $request->barium_content : NULL;
        $watermeasurement->total_iron_content = ($request->total_iron_content) ? $request->total_iron_content : NULL;
        $watermeasurement->ferric_iron_content = ($request->ferric_iron_content) ? $request->ferric_iron_content : NULL;
        $watermeasurement->ferrous_iron_content = ($request->ferrous_iron_content) ? $request->ferrous_iron_content : NULL;
        $watermeasurement->hydrogen_sulfide = ($request->hydrogen_sulfide) ? $request->hydrogen_sulfide : NULL;
        $watermeasurement->oxygen = ($request->oxygen) ? $request->oxygen : NULL;
        $watermeasurement->carbon_dioxide = ($request->carbon_dioxide) ? $request->carbon_dioxide : NULL;
        $watermeasurement->sulphate_reducing_bacteria_id = ($request->sulphate_reducing_bacteria_id) ? $request->sulphate_reducing_bacteria_id : NULL;
        $watermeasurement->hydrocarbon_oxidizing_bacteria_id = ($request->hydrocarbon_oxidizing_bacteria_id) ? $request->hydrocarbon_oxidizing_bacteria_id : NULL;
        $watermeasurement->thionic_bacteria_id = ($request->thionic_bacteria_id) ? $request->thionic_bacteria_id : NULL;
        $watermeasurement->cruser_id = Auth::user()->id;
        $watermeasurement->save();

        return redirect()->route('watermeasurement.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wm = ComplicationMonitoringWaterMeasurement::find($id);
        $wm->delete();

        return redirect()->route('watermeasurement.index')->with('success',__('app.deleted'));
    }

    public function getOtherObjects(){
        $otherObjects = RefsOtherObjects::get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $otherObjects
        ]);
    }

    public function getNgdu(){
        $ngdu = RefsNgdu::get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $ngdu
        ]);
    }

    public function getCdng(){
        $cdng = RefsCdng::get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $cdng
        ]);
    }

    public function getGu(Request $request){
        $gu = RefsGu::where('cdng_id', '=', $request->cdng_id)->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $gu
        ]);
    }

    public function getZu(Request $request){
        $zu = RefsZu::where('gu_id', '=', $request->gu_id)->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $zu
        ]);
    }

    public function getWell(Request $request){
        $wells = RefsWell::where('zu_id', '=', $request->zu_id)->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $wells
        ]);
    }

    public function getWaterBySulin(){
        $wbs = RefsWaterTypeBySulin::get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $wbs
        ]);
    }

    public function getSulphateReducingBacteria(){
        $srb = RefsSulphateReducingBacteria::get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $srb
        ]);
    }

    public function getHydrocarbonOxidizingBacteria(){
        $hob = RefsHydrocarbonOxidizingBacteria::get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $hob
        ]);
    }

    public function getThionicBacteria(){
        $hb = RefsThionicBacteria::get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $hb
        ]);
    }

    public function getWm(Request $request){
        $wm = ComplicationMonitoringWaterMeasurement::find($request->id);


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $wm
        ]);
    }

    public function getAllGu(){
        $gus = RefsGu::orderByRaw('name')->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $gus
        ]);
    }

    public function getGuData(Request $request){
        $wm = ComplicationMonitoringWaterMeasurement::where('gu_id','=',$request->gu_id)->get();
        $uhe = ComplicationMonitoringOmgUHE::where('gu_id','=',$request->gu_id)->get();
        $corrosion = ComplicationMonitoringCorrosion::where('gu_id','=',$request->gu_id)->get();
        $kormass = ComplicationMonitoringGuKormass::where('gu_id','=',$request->gu_id)->with('kormass')->first();
        $pipe = Pipe::where('gu_id','=',$request->gu_id)->where('plot','=','eg')->first();
        $pipeAB = Pipe::where('gu_id','=',$request->gu_id)->where('plot','=','ab')->first();
        $lastCorrosion = ComplicationMonitoringCorrosion::where('gu_id','=',$request->gu_id)->whereNotNull('corrosion_velocity_with_inhibitor')->latest()->first();
        $constantsValues = ConstantsValue::get();
        $chartDtCarbonDioxide['dt']  = [];
        $chartDtHydrogenSulfide['dt']  = [];
        $chartDtCarbonDioxide['value']  = [];
        $chartDtHydrogenSulfide['value']  = [];

        foreach($wm as $row){
            $date = new DateTime($row->date);
            array_push($chartDtCarbonDioxide['dt'], $date->format('Y-m-d'));
            array_push($chartDtHydrogenSulfide['dt'], $date->format('Y-m-d'));
            array_push($chartDtCarbonDioxide['value'], $row->carbon_dioxide);
            array_push( $chartDtHydrogenSulfide['value'], $row->hydrogen_sulfide);
        }

        $chartIngibitor['dt']  = [];
        $chartIngibitor['value']  = [];
        foreach($uhe as $row){
            $date = new DateTime($row->date);
            array_push($chartIngibitor['dt'], $date->format('Y-m-d'));
            array_push($chartIngibitor['value'], $row->current_dosage);
        }

        $chartCorrosion['dt']  = [];
        $chartCorrosion['value']  = [];
        foreach($corrosion as $row){
            $date = new DateTime($row->final_date_of_corrosion_velocity_with_inhibitor_measure);
            array_push($chartCorrosion['dt'], $date->format('Y-m-d'));
            array_push($chartCorrosion['value'], $row->corrosion_velocity_with_inhibitor);
        }

        if($kormass->kormass->name != 'Прямой УПСВ'){
            $kn = explode("-", $kormass->kormass->name);
            $kormass = $kn[1];
        }else{
            $kormass = 'Прямой УПСВ';
        }


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'chart1' => $chartDtCarbonDioxide,
            'chart2' => $chartDtHydrogenSulfide,
            'chart3' => $chartCorrosion,
            'chart4' => $chartIngibitor,
            'kormass' => $kormass,
            'pipe' => $pipe,
            'pipeab' => $pipeAB,
            'lastCorrosion' => $lastCorrosion,
            'constantsValues' => $constantsValues
        ]);
    }

    public function getGuNgduCdngField(Request $request){
        $gu = RefsGu::where('id','=',$request->gu_id)->first();
        $cdng = RefsCdng::where('id','=',$gu->cdng_id)->first();
        $kormass = ComplicationMonitoringGuKormass::where('gu_id','=',$request->gu_id)->first();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'cdng' => $gu->cdng_id,
            'ngdu' => $cdng->ngdu_id,
            'kormass' => $kormass->kormass_id
        ]);
    }

    public function getAllKormasses(){
        $kormasses = Kormass::orderBy('name')->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $kormasses
        ]);
    }
}

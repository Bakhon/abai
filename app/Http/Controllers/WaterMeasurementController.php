<?php

namespace App\Http\Controllers;

use App\Models\Cdng;
use App\Models\Gu;
use App\Models\HydrocarbonOxidizingBacteria;
use App\Models\Ngdu;
use App\Models\OtherObjects;
use App\Models\SulphateReducingBacteria;
use App\Models\ThionicBacteria;
use App\Models\WaterMeasurement;
use App\Models\WaterTypeBySulin;
use App\Models\Well;
use App\Models\Zu;
use App\Tables\WaterMeasurementTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaterMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wm = WaterMeasurement::orderByDesc('date')
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

        $wm = new WaterMeasurement;
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
        $wm = WaterMeasurement::where('id', '=', $id)
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
    public function edit($id)
    {
        $wm = WaterMeasurement::where('id', '=', $id)
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

        return view('watermeasurement.edit', compact('wm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);

        $wm = WaterMeasurement::find($request->id);
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
        $wm = WaterMeasurement::find($id);
        $wm->delete();

        return redirect()->route('watermeasurement.index')->with('success',__('app.deleted'));
    }

    public function getOtherObjects(){
        $otherObjects = OtherObjects::get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $otherObjects
        ]);
    }

    public function getNgdu(){
        $ngdu = Ngdu::get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $ngdu
        ]);
    }

    public function getCdng(Request $request){
        $cdng = Cdng::where('ngdu_id', '=', $request->ngdu_id)->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $cdng
        ]);
    }

    public function getGu(Request $request){
        $gu = Gu::where('cdng_id', '=', $request->cdng_id)->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $gu
        ]);
    }

    public function getZu(Request $request){
        $zu = Zu::where('gu_id', '=', $request->gu_id)->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $zu
        ]);
    }

    public function getWell(Request $request){
        $wells = Well::where('zu_id', '=', $request->zu_id)->get();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $wells
        ]);
    }

    public function getWaterBySulin(){
        $wbs = WaterTypeBySulin::get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $wbs
        ]);
    }

    public function getSulphateReducingBacteria(){
        $srb = SulphateReducingBacteria::get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $srb
        ]);
    }

    public function getHydrocarbonOxidizingBacteria(){
        $hob = HydrocarbonOxidizingBacteria::get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $hob
        ]);
    }

    public function getThionicBacteria(){
        $hb = ThionicBacteria::get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $hb
        ]);
    }

    public function getWm(Request $request){
        $wm = WaterMeasurement::find($request->id);


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $wm
        ]);
    }
}

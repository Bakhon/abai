<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Models\ComplicationMonitoring\OmgUHE as ComplicationMonitoringOmgUHE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OmgUHEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $omguhe = ComplicationMonitoringOmgUHE::orderByDesc('date')
                                ->with('ngdu')
                                ->with('cdng')
                                ->with('gu')
                                ->with('zu')
                                ->with('well')
                                ->paginate(10);



        return view('omguhe.index',compact('omguhe'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('omguhe.create');
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

        $omgohe = new ComplicationMonitoringOmgUHE;
        $omgohe->field = ($request->field) ? $request->field : NULL;
        $omgohe->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : NULL;
        $omgohe->cdng_id = ($request->cdng_id) ? $request->cdng_id : NULL;
        $omgohe->gu_id = ($request->gu_id) ? $request->gu_id : NULL;
        $omgohe->zu_id = ($request->zu_id) ? $request->zu_id : NULL;
        $omgohe->well_id = ($request->well_id) ? $request->well_id : NULL;
        $omgohe->date = date("Y-m-d H:i", strtotime($request->date));
        $omgohe->current_dosage = ($request->current_dosage) ? $request->current_dosage : NULL;
        $omgohe->daily_inhibitor_flowrate = ($request->daily_inhibitor_flowrate) ? $request->daily_inhibitor_flowrate : NULL;
        if($request->out_of_service_оf_dosing == true){
            $omgohe->out_of_service_оf_dosing = 1;
        }else{
            $omgohe->out_of_service_оf_dosing = 0;
        }
        $omgohe->reason = ($request->reason) ? $request->reason : NULL;
        $omgohe->cruser_id = Auth::user()->id;
        $omgohe->save();

        return redirect()->route('omguhe.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $omguhe = ComplicationMonitoringOmgUHE::where('id', '=', $id)
                            ->with('ngdu')
                            ->with('cdng')
                            ->with('gu')
                            ->with('zu')
                            ->with('well')
                            ->first();

        return view('omguhe.show', compact('omguhe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $omguhe = ComplicationMonitoringOmgUHE::find($id);
        $omguhe->delete();

        return redirect()->route('omguhe.index')->with('success',__('app.deleted'));
    }

    public function getPrevDayLevel(Request $request){
        $result = ComplicationMonitoringOmgUHE::where('gu_id', '=', $request->gu_id)
                                        ->where('date', '<', $request->date)
                                        ->where('out_of_service_оf_dosing', '<>', '1')
                                        ->latest()
                                        ->first();

        if($result){
            if($result->fill){
                return $result->fill;
            }else{
                return $result->level;
            }
        }else{
            return false;
        }
    }
}

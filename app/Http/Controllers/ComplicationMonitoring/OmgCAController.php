<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Http\Requests\OmgCAUpdateRequest;
use App\Models\ComplicationMonitoring\OmgCA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OmgCAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $omgca = OmgCA::orderByDesc('created_at')
                                ->with('ngdu')
                                ->with('cdng')
                                ->with('gu')
                                ->with('zu')
                                ->with('well')
                                ->paginate(10);



        return view('omgca.index',compact('omgca'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('omgca.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'year' => 'required',
        ]);

        $omgca = new OmgCA;
        $omgca->field = ($request->field) ? $request->field : NULL;
        $omgca->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : NULL;
        $omgca->cdng_id = ($request->cdng_id) ? $request->cdng_id : NULL;
        $omgca->gu_id = ($request->gu_id) ? $request->gu_id : NULL;
        $omgca->zu_id = ($request->zu_id) ? $request->zu_id : NULL;
        $omgca->well_id = ($request->well_id) ? $request->well_id : NULL;
        $omgca->date = $request->year."-01-01";
        $omgca->plan_dosage = ($request->plan_dosage) ? $request->plan_dosage : NULL;
        $omgca->q_v = ($request->q_v) ? $request->q_v : NULL;
        $omgca->cruser_id = Auth::user()->id;
        $omgca->save();

        return redirect()->route('omgca.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $omgca = OmgCA::where('id', '=', $id)
                            ->with('ngdu')
                            ->with('cdng')
                            ->with('gu')
                            ->with('zu')
                            ->with('well')
                            ->first();

        return view('omgca.show', compact('omgca'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(OmgCA $omgca)
    {
        $omgca->load('history');
        return view('omgca.history', compact('omgca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OmgCA $omgca)
    {
        return view('omgca.edit', compact('omgca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OmgCAUpdateRequest $request, OmgCA $omgca)
    {
        $omgca->update($request->validated());
        return redirect()->route('omgca.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $omgca = OmgCA::find($id);
        $omgca->delete();

        return redirect()->route('omgca.index')->with('success',__('app.deleted'));
    }

    public function checkDublicate(Request $request){
        $query = OmgCA::where('date','=',$request->dt)
                      ->where('gu_id','=',$request->gu);

        if($request->id) {
            $query->where('id', '!=', $request->id);
        }

        $row = $query->first();

        if ($row) {
            return response()->json(false);
        }else{
            return response()->json(true);
        }
    }
}

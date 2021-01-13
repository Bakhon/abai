<?php

namespace App\Http\Controllers\VisCenter\KPI;

use Illuminate\Http\Request;
use App\Models\EcoRefsCompaniesId;
use App\Models\VisCenter\KPI\TypeId;
use App\Models\VisCenter\KPI\MarabKpiId;
use App\Models\VisCenter\KPI\Marab345;
use App\Http\Controllers\Controller;
use Carbon\Carbon;


class Marab345Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marab345 = Marab345::latest()->with('marabkpi')->paginate(5); 
        $marab345 = Marab345::latest()->with('company')->paginate(5); 
        $marab345 = Marab345::latest()->with('type')->paginate(5); 

        return view('viscenterKPI.marab345.index',compact('marab345'))
            ->with('i', (request()->input('page', 1) - 1) * 5); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = EcoRefsCompaniesId::get();
        $marabkpi = MarabKpiId::get();
        $type = TypeId::get();
        return view('viscenterKPI.marab345.create',compact('company', 'marabkpi', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $alldata = new Marab345;
        // $alldata->__time =  (Carbon::parse($request->date))->getTimestamp() * 1000 - 86400000;
        // $alldata->save();

        $request->validate([
            'company_id' => 'required',
            'marabkpi_id' => 'required',
            'type_id' => 'required',
            'date'=> 'required',
            // 'fact_zatraty_na_sebestoimost_dobychi_nefti' => 'required',
            // 'fact_zatraty_kapitalnogo_vlozhenia' => 'required',
            // 'opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov' => 'required',
            ]);
        
        Marab345::create($request->all());

        return redirect()->route('marab345.index')->with('success',__('app.created'));
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
        $row = Marab345::find($id);
        $company = EcoRefsCompaniesId::get();
        $marabkpi = MarabKpiId::get();
        $type = TypeId::get();
        return view('viscenterKPI.marab345.edit',compact('row', 'company', 'marabkpi', 'type'));
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
        $marab345=Marab345::find($id);
        $request->validate([
            'company_id' => 'required',
            'marabkpi_id' => 'required',
            'type_id' => 'required',
            'date'=> 'required',
            // 'fact_zatraty_na_sebestoimost_dobychi_nefti' => 'required',
            // 'fact_zatraty_kapitalnogo_vlozhenia' => 'required',
            // 'opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov' => 'required',
        ]);

        $marab345->update($request->all());

        return redirect()->route('marab345.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Marab345::find($id);
        $row->delete();

        return redirect()->route('marab345.index')->with('success',__('app.deleted'));
    }
}

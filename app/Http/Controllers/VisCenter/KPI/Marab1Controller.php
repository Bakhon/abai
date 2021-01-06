<?php

namespace App\Http\Controllers\VisCenter\KPI;

use Illuminate\Http\Request;
use App\Models\EcoRefsCompaniesId;
use App\Models\VisCenter\KPI\TypeId;
use App\Models\VisCenter\KPI\Marab1;
use App\Http\Controllers\Controller;

class Marab1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marab1 = Marab1::latest()->with('type')->paginate(5); 
        $marab1 = Marab1::latest()->with('company')->paginate(5); 

        return view('viscenterKPI.marab1.index',compact('marab1'))
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
        return view('viscenterKPI.marab1.create',compact('company', 'type'));
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
            // 'A_category' => 'required',
            // 'B_category' => 'required',
            // 'C1_category' => 'required',
            ]);

            Marab1::create($request->all());


        return redirect()->route('marab1.index')->with('success',__('app.created'));
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
        $row = Marab1::find($id);
        $company = EcoRefsCompaniesId::get();
        $type = TypeId::get();
        return view('viscenterKPI.marab1.edit',compact('row', 'company', 'type'));
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
        $marab1=Marab1::find($id);
        $request->validate([
            'company_id' => 'required',
            'type_id' => 'required',
            'date' => 'required',
            // 'A_category' => 'required',
            // 'B_category' => 'required',
            // 'C1_category' => 'required',
        ]);

        $marab1->update($request->all());

        return redirect()->route('marab1.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Marab1::find($id);
        $row->delete();

        return redirect()->route('marab1.index')->with('success',__('app.deleted'));
    }
}

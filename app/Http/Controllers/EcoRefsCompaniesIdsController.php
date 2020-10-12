<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsCompaniesId;
use Illuminate\Http\Request;

class EcoRefsCompaniesIdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefscompanies = EcoRefsCompaniesId::latest()->paginate(5);

        return view('ecorefscompanies.index',compact('ecorefscompanies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecorefscompanies.create');
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

        EcoRefsCompaniesId::create($request->all());

        return redirect()->route('ecorefscompaniesids.index')->with('success',__('app.created'));
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
        $EcoRefsCompaniesId = EcoRefsCompaniesId::find($id);
        return view('ecorefscompanies.edit',compact('EcoRefsCompaniesId'));

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
        $EcoRefsCompaniesId=EcoRefsCompaniesId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsCompaniesId->update($request->all());

        return redirect()->route('ecorefscompaniesids.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsCompaniesId = EcoRefsCompaniesId::find($id);
        $EcoRefsCompaniesId->delete();

        return redirect()->route('ecorefscompaniesids.index')->with('success',__('app.deleted'));
        //
    }
}

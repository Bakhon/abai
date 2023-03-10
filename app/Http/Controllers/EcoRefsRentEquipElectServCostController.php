<?php

namespace App\Http\Controllers;

use App\Models\Refs\EcoRefsScFa;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsRentEquipElectServCost;
use App\Models\EcoRefsEquipId;

use Illuminate\Http\Request;

class EcoRefsRentEquipElectServCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $ecorefsrentequipelectservcost = EcoRefsRentEquipElectServCost::latest()->with('scfa')->with('company')->with('equip')->paginate(5);

            return view('economy_kenzhe/ecorefsrentequipelectservcost.index',compact('ecorefsrentequipelectservcost'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        $equip = EcoRefsEquipId::get();
        return view('economy_kenzhe/ecorefsrentequipelectservcost.create',compact('sc_fa', 'company', 'equip'));
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
            'sc_fa' => 'required',
            'company_id' => 'required',
            'equip_id' => 'required',
            'date' => 'required',
            'rent_cost' => 'required',
            'equip_cost' => 'required',
            'elect_cons' => 'required',
            'dayli_serv_cost' => 'required',
        ]);

        EcoRefsRentEquipElectServCost::create($request->all());

        return redirect()->route('ecorefsrentequipelectservcost.index')->with('success',__('app.created'));
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
        $row = EcoRefsRentEquipElectServCost::find($id);
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        $equip = EcoRefsEquipId::get();

        return view('economy_kenzhe/ecorefsrentequipelectservcost.edit',compact('sc_fa', 'row', 'company', 'equip'));
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
        $EcoRefsRentEquipElectServCost=EcoRefsRentEquipElectServCost::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'equip_id' => 'required',
            'date' => 'required',
            'rent_cost' => 'required',
            'equip_cost' => 'required',
            'elect_cons' => 'required',
            'dayli_serv_cost' => 'required',
        ]);

        $EcoRefsRentEquipElectServCost->update($request->all());

        return redirect()->route('ecorefsrentequipelectservcost.index')->with('success',__('app.updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsRentEquipElectServCost::find($id);
        $row->delete();

        return redirect()->route('ecorefsrentequipelectservcost.index')->with('success',__('app.deleted'));
    }
}

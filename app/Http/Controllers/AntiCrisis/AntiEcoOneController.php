<?php

namespace App\Http\Controllers\AntiCrisis;

use App\Http\Controllers\Controller;
use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EcoRefsScFa;
use App\Models\AntiRefs\AntiEcoOne;
use Illuminate\Http\Request;

class AntiEcoOneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $antiecoone = AntiEcoOne::latest()->with('scfa')->with('company')->paginate(5);

        return view('antiecoone.index',compact('antiecoone'))
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
        return view('antiecoone.create',compact('sc_fa', 'company'));
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
            'dbeg' => 'required',
            'dend' => 'required',
            'bar_coef_exp_one' => 'required',
            'bar_coef_exp_two' => 'required',
            'bar_coef_exp_three' => 'required',
            'bar_coef_ins_one' => 'required',
            'bar_coef_ins_two' => 'required',
            'sales_share_exp_one' => 'required',
            'sales_share_exp_two' => 'required',
            'sales_share_exp_three' => 'required',
            'sales_share_ins_one' => 'required',
            'sales_share_ins_two' => 'required',
            'disc_exp_one' => 'required',
            'disc_exp_two' => 'required',
            'disc_exp_three' => 'required',
            'disc_ins_one' => 'required',
            'disc_ins_two' => 'required',
            'trans_exp_cost_one' => 'required',
            'trans_exp_cost_two' => 'required',
            'trans_exp_cost_three' => 'required',
            'trans_ins_cost_one' => 'required',
            'trans_ins_cost_two' => 'required',
            'var_cost_one' => 'required',
            'var_cost_two' => 'required',
            'fix_cost_one' => 'required',
            'fix_cost_two' => 'required',
            'fix_cost_three' => 'required',
            'fix_cost_four' => 'required',
            'adm_exp' => 'required',
            'avg_prs_cost' => 'required',
            'fot_prs' => 'required',
            'avg_prs_cost_fot' => 'required',
            'avg_krs_cost' => 'required',
            'amort' => 'required',
        ]);

        AntiEcoOne::create($request->all());

        return redirect()->route('antiecoone.index')->with('success',__('app.created'));
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
        $row = AntiEcoOne::find($id);
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        return view('antiecoone.edit',compact('row', 'sc_fa', 'company'));

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
        $AntiEcoOne=AntiEcoOne::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'dbeg' => 'required',
            'dend' => 'required',
            'bar_coef_exp_one' => 'required',
            'bar_coef_exp_two' => 'required',
            'bar_coef_exp_three' => 'required',
            'bar_coef_ins_one' => 'required',
            'bar_coef_ins_two' => 'required',
            'sales_share_exp_one' => 'required',
            'sales_share_exp_two' => 'required',
            'sales_share_exp_three' => 'required',
            'sales_share_ins_one' => 'required',
            'sales_share_ins_two' => 'required',
            'disc_exp_one' => 'required',
            'disc_exp_two' => 'required',
            'disc_exp_three' => 'required',
            'disc_ins_one' => 'required',
            'disc_ins_two' => 'required',
            'trans_exp_cost_one' => 'required',
            'trans_exp_cost_two' => 'required',
            'trans_exp_cost_three' => 'required',
            'trans_ins_cost_one' => 'required',
            'trans_ins_cost_two' => 'required',
            'var_cost_one' => 'required',
            'var_cost_two' => 'required',
            'fix_cost_one' => 'required',
            'fix_cost_two' => 'required',
            'fix_cost_three' => 'required',
            'fix_cost_four' => 'required',
            'adm_exp' => 'required',
            'avg_prs_cost' => 'required',
            'fot_prs' => 'required',
            'avg_prs_cost_fot' => 'required',
            'avg_krs_cost' => 'required',
            'amort' => 'required',
        ]);

        $AntiEcoOne->update($request->all());

        return redirect()->route('antiecoone.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = AntiEcoOne::find($id);
        $row->delete();

        return redirect()->route('antiecoone.index')->with('success',__('app.deleted'));
    }
}

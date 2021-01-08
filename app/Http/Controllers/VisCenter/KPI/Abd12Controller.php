<?php

namespace App\Http\Controllers\VisCenter\KPI;

use Illuminate\Http\Request;
use App\Models\VisCenter\KPI\TypeId;
use App\Models\VisCenter\KPI\AbdKpiId;
use App\Models\VisCenter\KPI\Abd12;
use App\Http\Controllers\Controller;

class Abd12Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abd12 = Abd12::latest()->with('type')->paginate(5); 
        $abd12 = Abd12::latest()->with('abdkpi')->paginate(5); 

        return view('viscenterKPI.abd12.index',compact('abd12'))
            ->with('i', (request()->input('page', 1) - 1) * 5); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = TypeId::get();
        $abdkpi = AbdKpiId::get();
        return view('viscenterKPI.abd12.create',compact('type','abdkpi'));
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
            'abdkpi_id' => 'required',
            'type_id'=> 'required',
            // 'date_col' => 'required',
            'aim_params' => 'required',
            // 'fact' => 'required',
            'remaining_days' => 'required',
            'expactations_percentage' => 'required',
            ]);

        Abd12::create($request->all());

        return redirect()->route('abd12.index')->with('success',__('app.created'));
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
        $row = Abd12::find($id);
        $abdkpi = AbdKpiId::get();
        $type = TypeId::get();
        return view('viscenterKPI.abd12.edit',compact('row', 'abdkpi', 'type'));
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
        $abd12=Abd12::find($id);
        $request->validate([
            'abdkpi_id' => 'required',
            'type_id'=> 'required',
            // 'date_col' => 'required',
            'aim_params' => 'required',
            // 'fact' => 'required',
            'remaining_days' => 'required',
            'expactations_percentage' => 'required',
            ]);

        $abd12->update($request->all());

        return redirect()->route('abd12.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Abd12::find($id);
        $row->delete();

        return redirect()->route('abd12.index')->with('success',__('app.deleted'));
    }
}

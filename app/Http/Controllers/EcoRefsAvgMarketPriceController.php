<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsAvgMarketPrice;
use Illuminate\Http\Request;

class EcoRefsAvgMarketPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsavgmarketprice = EcoRefsAvgMarketPrice::latest()->paginate(5);

        return view('ecorefsavgmarketprice.index',compact('ecorefsavgmarketprice'))
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
        return view('ecorefsavgmarketprice.create');
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
            'avg_market_price_beg' => 'required',
            'avg_market_price_end' => 'required',
            'exp_cust_duty_rate' => 'required',
        ]);

        EcoRefsAvgMarketPrice::create($request->all());

        return redirect()->route('ecorefsavgmarketprice.index')->with('success',__('app.created'));
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
        $EcoRefsAvgMarketPrice = EcoRefsAvgMarketPrice::find($id);
        return view('ecorefsavgmarketprice.edit',compact('EcoRefsAvgMarketPrice'));
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
        $EcoRefsAvgMarketPrice=EcoRefsAvgMarketPrice::find($id);
        $request->validate([
            'avg_market_price_beg' => 'required',
            'avg_market_price_end' => 'required',
            'exp_cust_duty_rate' => 'required',
        ]);

        $EcoRefsAvgMarketPrice->update($request->all());

        return redirect()->route('ecorefsavgmarketprice.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsAvgMarketPrice = EcoRefsAvgMarketPrice::find($id);
        $EcoRefsAvgMarketPrice->delete();

        return redirect()->route('ecorefsavgmarketprice.index')->with('success',__('app.deleted'));
    }
}

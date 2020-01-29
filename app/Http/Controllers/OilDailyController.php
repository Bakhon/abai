<?php

namespace App\Http\Controllers;

use App\Models\OilDaily;
use Illuminate\Http\Request;

class OilDailyController extends Controller
{
    public function index()
    {
        $oildaily = OilDaily::latest()->paginate(5);

        return view('oildaily.index',compact('oildaily'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        return view('oildaily.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'liquid' => 'required',
            'date' => 'required',
        ]);

        OilDaily::create($request->all());

        return redirect()->route('oildaily.index')->with('success','OilDaily created successfully.');
    }


    public function edit($id)
    {
        $oilDaily = OilDaily::find($id);
        return view('oildaily.edit',compact('oilDaily'));
    }


    public function update(Request $request, OilDaily $oilDaily)
    {
        $request->validate([
            'liquid' => 'required',
            'date' => 'required',
        ]);

        $oilDaily->update($request->all());

        return redirect()->route('oildaily.index')->with('success','OilDaily updated successfully');
    }


    public function destroy($id)
    {
        $oilDaily = OilDaily::find($id);
        $oilDaily->delete();

        return redirect()->route('oildaily.index')->with('success','OilDaily deleted successfully');
    }
}

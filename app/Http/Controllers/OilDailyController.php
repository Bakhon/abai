<?php

namespace App\Http\Controllers;

use App\Models\OilDaily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function edit(OilDaily $oilDaily)
    {
        return view('oildaily.edit',compact('oilDaily'));
    }


    public function update(Request $request, OilDaily $oilDaily)
    {
        $request->validate([
            'liquid' => 'required',
            'date' => 'required',
        ]);

        $oilDaily->update($request->all());

        return redirect()->route('products.index')->with('success','OilDaily updated successfully');
    }


    public function destroy(OilDaily $oilDaily)
    {
        $oilDaily->delete();

        return redirect()->route('oildaily.index')->with('success','OilDaily deleted successfully');
    }
}

<?php
namespace App\Http\Controllers\PlastFluids;
use App\Http\Controllers\Controller;


class PlastFluidsController extends Controller
{
    public function pf()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();       
        
        return view('plastfluids.pf', compact('permissionNames'));
    }  

    public function pf_tmpl_pvt_plast_oil()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();       
        
        return view('plastfluids.pf_template_pvt_plast_oil', compact('permissionNames'));
    }  

}

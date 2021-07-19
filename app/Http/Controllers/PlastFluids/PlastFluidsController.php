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

    public function pfTmplPvtPlastOil()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();       
        
        return view('plastfluids.pf_template_pvt_plast_oil', compact('permissionNames'));
    }  

    public function pfUploadMonitoring()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();       
        
        return view('plastfluids.pf_upload_monitoring', compact('permissionNames'));
    } 

}

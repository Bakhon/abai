<?php

namespace App\Http\Controllers\gno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GNOController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:podborGno view main')->only('index');
    
    }
    public function index()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();
        return view('gno.gno', compact('permissionNames'));
    }

}

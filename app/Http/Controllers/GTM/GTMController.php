<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;

class GTMController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:podborGtm view main')->only('index');
    
    }

    public function index()
    {
        return view('gtm.gtm');
    }

}

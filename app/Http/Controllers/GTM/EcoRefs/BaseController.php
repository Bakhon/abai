<?php

namespace App\Http\Controllers\GTM\EcoRefs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BaseController extends Controller
{
    public function index(): View
    {
        return view('gtm.EcoRefs.index');
    }
}

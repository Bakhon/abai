<?php

namespace App\Http\Controllers\Geology;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    public function index()
    {
        return view('geology.core');
    }
}

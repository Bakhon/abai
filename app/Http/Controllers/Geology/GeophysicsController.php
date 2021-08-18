<?php

namespace App\Http\Controllers\Geology;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeophysicsController extends Controller
{
    public function index()
    {
        return view('geology.geophysics');
    }
}

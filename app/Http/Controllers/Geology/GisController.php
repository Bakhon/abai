<?php

namespace App\Http\Controllers\Geology;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GisController extends Controller
{
    public function index()
    {
        return view('geology.gis');
    }
}

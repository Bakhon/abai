<?php

namespace App\Http\Controllers\MapConstructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapConstructorController extends Controller
{
    public function index()
        {
            return view('map_constructor.index');
        }
}

<?php

namespace App\Http\Controllers\MapConstructor;

use App\Http\Controllers\Controller;

class MapConstructorController extends Controller
{
    public function __construct() {
        $this->middleware('can:mapConstructor view')->only('index');
    }

    public function index() {
        return view('map_constructor.index');
    }
}

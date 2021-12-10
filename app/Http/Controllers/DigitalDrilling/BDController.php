<?php

namespace App\Http\Controllers\DigitalDrilling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BDController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:digitalDrilling view main')
            ->only([
                'index',
                'home'
            ]);
    }

    public function home()
    {
        return view('digital_drilling.index');
    }

    public function index()
    {
        return view('digital_drilling.digital-drilling');
    }
}
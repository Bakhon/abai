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
        $user = json_encode(auth()->user()->load('profile'));

        $user_can = auth()->user()->can('digitalDrilling delete catalog');

        return view('digital_drilling.index', compact('user', 'user_can'));
    }

    public function index()
    {
        $user = json_encode(auth()->user()->load('profile'));

        $user_can = auth()->user()->can('digitalDrilling view catalog');

        return view('digital_drilling.digital-drilling', compact('user', 'user_can'));
    }
}
<?php

namespace App\Http\Controllers\ProdPlanning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LongTermProgramController extends Controller
{
    public function index()
    {
        return view('prod_planning.long_term_program');
    }
}
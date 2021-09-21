<?php
namespace App\Http\Controllers\Tkrs;
use App\Http\Controllers\Controller;


class TkrsController extends Controller
{
    
    public function tkrsMain()
    {
        return view('tkrsMain.tkrsMain');
    }   
}
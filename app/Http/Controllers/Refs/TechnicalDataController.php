<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class TechnicalDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function refsList(){
        return view('technical_forecast.list');
    }

}

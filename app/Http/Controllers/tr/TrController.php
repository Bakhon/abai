<?php

namespace App\Http\Controllers\tr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Extractions\ExtractionBuilder;
use App\Models\DZO\DZOdaily;


class TrController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:tr view main')->only('tr', 'fa', 'trfa', 'tr_charts');
    }
    public function tr()
    {
        return view('tr.tr');
    }   
    public function fa()
    {
        return view('fa.fa');
    }   
    public function trfa()
    {
        return view('trfa.trfa');
    }    
    public function tr_charts()
    {
        return view('tr_charts.tr_charts');
    }    

}
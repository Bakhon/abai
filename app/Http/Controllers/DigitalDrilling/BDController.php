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
                'info',
                'passport',
                'gis',
                'structure',
                'structureGraph',
                'inclino',
                'inclinoGraph',
                'projectData',
                'home'
            ]);
    }

    public function home()
    {
        return view('digital_drilling.index');
    }

    public function index()
    {
        return view('digital_drilling.bd.home');
    }

    public function info()
    {
        return view('digital_drilling.bd.info');
    }

    public function passport()
    {
        return view('digital_drilling.bd.passport');
    }

    public function gis()
    {
        return view('digital_drilling.bd.gis');
    }

    public function structure()
    {
        return view('digital_drilling.bd.structure');
    }

    public function structureGraph()
    {
        return view('digital_drilling.bd.structure-graph');
    }

    public function inclino()
    {
        return view('digital_drilling.bd.inclino');
    }

    public function inclinoGraph()
    {
        return view('digital_drilling.bd.inclino-graph');
    }

    public function projectData()
    {
        return view('digital_drilling.bd.project-data');
    }
}
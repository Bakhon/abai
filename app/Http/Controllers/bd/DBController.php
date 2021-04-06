<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Models\DZO\DZOdaily;

class DBController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:bigdata view main')->only('bigdata', 'form', 'las', 'userReports');
    }

    public function mzdn()
    {
        return view('reports.mzdn');
    }

    public function bigdata()
    {
        return view('reports.bigdata');
    }

    public function las()
    {
        return view('reports.las');
    }

    public function userReports()
    {
        return view('reports.user_reports');
    }

    public function constructor()
    {
        return view('reports.constructor');
    }
    public function gtm()
    {
        return view('reports.gtm');
    }

    public function dob()
    {
        return view('reports.dob');
    }

    public function form()
    {
        return view('protodb.form');
    }

    public function mobileForm()
    {
        return view('protodb.form_mobile');
    }

    public function reports()
    {
        $sections = \App\Models\BigdataSection::all();
        return \App\Http\Resources\BigdataSectionResource::collection($sections);
    }

    public function favoriteReports()
    {
        $reports = auth()->user()->bigdataFavoriteReports->pluck('id');
        return $reports;
    }

    public function addReportToFavorites(\App\Models\BigdataReport $report)
    {
        auth()->user()->bigdataFavoriteReports()->attach($report);
        return [];
    }

    public function removeReportFromFavorites(\App\Models\BigdataReport $report)
    {
        auth()->user()->bigdataFavoriteReports()->detach($report);
        return [];
    }

}

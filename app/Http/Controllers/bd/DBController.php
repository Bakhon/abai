<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Models\BigData\Dictionaries\Geo;
use App\Models\DZO\DZOdaily;
use App\Models\ReportTemplate;
use Illuminate\Http\Request;

class DBController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:bigdata view main')->only('bigdata', 'form', 'las', 'userReports', 'geoDataReferenceBook');
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
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        return view('reports.las', compact('permissionNames'));
    }


    public function well_card()
    {
        return view('bigdata.well_card.index');
    }

    public function field_list()
    {
        $geoList = Geo::where('geo_type', 3)->orderBy('name_ru')->get();
        return $geoList;
    }

    public function report_constructor()
    {
        return view('reports.report_constructor');
    }

    public function geoDataReferenceBook()
    {
        return view('reports.geo_data_reference_book');
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

    public function saveTemplate(Request $request)
    {
        $template = $request->json()->all();
        ReportTemplate::create(
            [
                'template' => $template['template'],
                'name' => $template['name'],
                'user_id' => auth()->id()
            ]
        );
    }

    public function getTemplates()
    {
        return ReportTemplate::select('id', 'template', 'name')
            ->where('user_id', auth()->id())
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

}

<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Models\DZO\DZOdaily;
use App\Models\BigData\Dictionaries\Geo;
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
        $translation = new \stdClass();
        $translation->case_well = trans('well.case_well');
        $translation->well = trans('well.well');
        $translation->all_dzo = trans('well.all_dzo');
        $translation->number_well = trans('well.number_well');
        $translation->general = trans('well.general');
        $translation->category_well = trans('well.category_well');
        $translation->binding = trans('well.binding');
        $translation->org_struct = trans('well.org_struct');
        $translation->coord = trans('well.coord');
        $translation->zaboi = trans('well.zaboi');
        $translation->zaboi_x = trans('well.zaboi_x');
        $translation->zaboi_y = trans('well.zaboi_y');
        $translation->well_passport = trans('well.well_passport');
        $translation->download_excel = trans('well.download_excel');
        $translation->general_info =  trans('well.general_info');
        $params =['translation'=>json_encode($translation)];

        return view('bigdata.well_card.index',$params);
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

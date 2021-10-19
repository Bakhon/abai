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
        $translation->view_well = trans('well.view_well');
        $translation->well_field = trans('well.well_field');
        $translation->horizont_rnas = trans('well.horizont_rnas');
        $translation->h_rotor = trans('well.h_rotor');
        $translation->tech_struct = trans('well.tech_struct');
        $translation->otvod = trans('well.otvod');
        $translation->gu_zu = trans('well.gu_zu');
        $translation->zone_well = trans('well.zone_well');
        $translation->influence_well = trans('well.influence_well');
        $translation->coord_x_outfall = trans('well.coord_x_outfall');
        $translation->coord_y_outfall = trans('well.coord_y_outfall');
        $translation->coord_zaboi_x = trans('well.coord_zaboi_x');
        $translation->coord_zaboi_y = trans('well.coord_zaboi_y');
        $translation->assign_well_project = trans('well.assign_well_project');
        $translation->category = trans('well.category');
        $translation->period_bur = trans('well.period_bur');
        $translation->date_expluatation = trans('well.date_expluatation');
        $translation->status = trans('well.status');
        $translation->way_expluatation = trans('well.way_expluatation');
        $translation->uo_bolt = trans('well.uo_bolt');
        $translation->diametr = trans('well.diametr');
        $translation->type_gol = trans('well.type_gol');
        $translation->pump_depth = trans('well.pump_depth');
        $translation->code_pump = trans('well.code_pump');
        $translation->diametr_pump = trans('well.diameter_pump');
        $translation->sk = trans('well.sk');
        $translation->length_hod = trans('well.length_hod');
        $translation->count_swaing = trans('well.count_swaing');
        $translation->fact_zaboi = trans('well.fact_zaboi');
        $translation->synthetic_zaboi = trans('well.synthetic_zaboi');
        $translation->broken_zaboi = trans('well.broken_zaboi');
        $translation->depth_down = trans('well.depth_down');
        $translation->date_perforation = trans('well.date_perforation');
        $translation->progress_interval_perforation = trans('well.progress_interval_perforation');
        $translation->debit_water = trans('well.debit_water');
        $translation->water_cut = trans('well.water_cut');
        $translation->debit_oil = trans('well.debit_oil');
        $translation->date_krs = trans('well.date_krs');
        $translation->date_sko = trans('well.date_sko');
        $translation->date_prc = trans('well.date_prc');
        $translation->date_last_gis = trans('well.date_last_gis');
        $translation->date_last_gdis = trans('well.date_last_gdis');
        $translation->result_gdm = trans('well.result_gdm');
        $translation->length_hod_gdm = trans('well.length_hod_gdm');
        $translation->count_swing = trans('well.count_swing');
        $translation->dynamic_level = trans('well.dynamic_level');
        $translation->static_level = trans('well.static_level');
        $translation->rpl_date = trans('well.rpl_date');
        $translation->rpl_sl_gdis = trans('well.rpl_sl_gdis');
        $translation->rzab = trans('well.rzab');
        $translation->rzatr = trans('well.rzatr');
        $translation->rzatr_stat = trans('well.rzatr_stat');
        $translation->note = trans('well.note');
        $translation->reactive_wells = trans('well.reactive_wells');
        $translation->packer_running_depth = trans('well.packer_running_depth');
        $translation->kshd = trans('well.kshd');
        $translation->pickup = trans('well.pickup');
        $translation->injection_pressure = trans('well.injection_pressure');
        $translation->date_pfp = trans('well.date_pfp');
        $translation->date_kpd = trans('well.date_kpd');


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

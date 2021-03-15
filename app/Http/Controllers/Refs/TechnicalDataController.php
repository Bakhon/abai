<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Imports\TechRefsProductionDataImport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

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

    public function uploadExcel(){
        return view('tech_refs.import_excel');
    }
    public function importExcel(Request $request){
        Excel::import(new TechRefsProductionDataImport, $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
    }

}

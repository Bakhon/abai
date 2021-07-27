<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Technical\ImportExcelTechnicalDataRequest;
use App\Imports\TechnicalDataForecastImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TechnicalDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function refsList()
    {
        return view('technical_forecast.list');
    }

    public function uploadExcel()
    {
        return view('technical_forecast.import_excel');
    }

    public function importExcel(ImportExcelTechnicalDataRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new TechnicalDataForecastImport(auth()->id(), $fileName);

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}

<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\WellForecast\EconomicWellForecastImportExcelRequest;
use App\Imports\Economic\EconomicWellForecastImport;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsWellForecast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EconomicWellForecastController extends Controller
{
    public function index(): View
    {
        $logType = EconomicDataLogType::WELL_FORECAST;

        return view('economic.well_forecast.index', compact('logType'));
    }

    public function getData(Request $request): array
    {
        $query = EcoRefsWellForecast::query();

        if ($request->uwi) {
            $query->whereUwi($request->uwi);
        }

        return $query
            ->with('author')
            ->get()
            ->toArray();
    }

    public function uploadExcel(): View
    {
        $mimeTypes = EconomicWellForecastImportExcelRequest::MIME_TYPES;

        return view('economic.well_forecast.import_excel', compact('mimeTypes'));
    }

    public function importExcel(EconomicWellForecastImportExcelRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            Excel::import(
                new EconomicWellForecastImport(auth()->id(), $fileName),
                $request->file
            );
        });

        return back()->with('success', __('app.success'));
    }
}

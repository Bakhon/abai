<?php

namespace App\Http\Controllers\Economic\Technical;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Technical\WellForecast\TechnicalWellForecastDataRequest;
use App\Http\Requests\Economic\Technical\WellForecast\TechnicalWellForecastImportExcelRequest;
use App\Imports\Economic\Technical\TechnicalWellForecastImport;
use App\Models\Refs\TechnicalWellForecast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class TechnicalWellForecastController extends Controller
{
    public function getData(TechnicalWellForecastDataRequest $request): array
    {
        $query = TechnicalWellForecast::query();

        if ($request->log_id) {
            $query->whereLogId($request->log_id);
        }

        if ($request->uwi) {
            $query->whereUwi($request->uwi);
        }

        return $query
            ->with(['author', 'status', 'lossStatus'])
            ->get()
            ->toArray();
    }

    public function uploadExcel(): View
    {
        $mimeTypes = TechnicalWellForecastImportExcelRequest::MIME_TYPES;

        return view('economic.technical.well_forecast.import_excel', compact('mimeTypes'));
    }

    public function importExcel(TechnicalWellForecastImportExcelRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            Excel::import(
                new TechnicalWellForecastImport(auth()->id(), $fileName),
                $request->file
            );
        });

        return back()->with('success', __('app.success'));
    }
}

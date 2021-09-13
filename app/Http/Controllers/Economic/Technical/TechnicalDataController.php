<?php

namespace App\Http\Controllers\Economic\Technical;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Technical\TechnicalDataForecastImportExcelRequest;
use App\Imports\Economic\Technical\TechnicalDataForecastImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class TechnicalDataController extends Controller
{
    public function list(): View
    {
        return view('economic.technical.list');
    }

    public function uploadExcel(): View
    {
        $mimeTypes = TechnicalDataForecastImportExcelRequest::MIME_TYPES;

        return view('economic.technical.forecast.import_excel', compact('mimeTypes'));
    }

    public function importExcel(TechnicalDataForecastImportExcelRequest $request): RedirectResponse
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

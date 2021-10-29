<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Technical\WellForecast\TechnicalWellForecastDataRequest;
use App\Http\Requests\Economic\Technical\WellForecast\TechnicalWellForecastImportExcelRequest;
use App\Imports\Economic\EconomicAnalysisParamImport;
use App\Models\Refs\EcoRefsAnalysisParam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EconomicAnalysisParamController extends Controller
{
    public function getData(TechnicalWellForecastDataRequest $request): array
    {
        $query = EcoRefsAnalysisParam::query();

        if ($request->log_id) {
            $query->whereLogId($request->log_id);
        }

        return $query
            ->with(['user'])
            ->get()
            ->toArray();
    }

    public function uploadExcel(): View
    {
        $mimeTypes = TechnicalWellForecastImportExcelRequest::MIME_TYPES;

        return view('economic.analysis.param.import_excel', compact('mimeTypes'));
    }

    public function importExcel(TechnicalWellForecastImportExcelRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            Excel::import(
                new EconomicAnalysisParamImport(auth()->id(), $fileName),
                $request->file
            );
        });

        return back()->with('success', __('app.success'));
    }
}

<?php

namespace App\Http\Controllers\Economic\Technical;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Technical\WellForecast\TechnicalWellForecastDataRequest;
use App\Http\Requests\Economic\Technical\WellForecast\TechnicalWellForecastImportExcelRequest;
use App\Imports\Economic\Technical\TechnicalWellForecastImport;
use App\Jobs\Economic\Technical\TechnicalWellForecastSuccessImportJob;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellLossStatus;
use App\Models\Refs\TechnicalWellStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TechnicalWellForecastController extends Controller
{
    public function getData(TechnicalWellForecastDataRequest $request): array
    {
        $query = DB::table((new TechnicalWellForecast())->getTable());

        if ($request->log_id) {
            $query->whereLogId($request->log_id);
        }

        if ($request->uwi) {
            $query->whereUwi($request->uwi);
        }

        $wells = $query->get()->toArray();

        $statuses = TechnicalWellStatus::all();

        $lossStatuses = TechnicalWellLossStatus::all();

        foreach ($wells as &$well) {
            $well = (array)$well;

            if ($well['status_id']) {
                $well['status'] = $statuses->firstWhere('id', $well['status_id']);
            }

            if ($well['loss_status_id']) {
                $well['loss_status'] = $lossStatuses->firstWhere('id', $well['loss_status_id']);
            }
        }

        return $wells;
    }

    public function uploadExcel(): View
    {
        $mimeTypes = TechnicalWellForecastImportExcelRequest::MIME_TYPES;

        return view('economic.technical.well_forecast.import_excel', compact('mimeTypes'));
    }

    public function importExcel(TechnicalWellForecastImportExcelRequest $request): RedirectResponse
    {
        $fileName = pathinfo(
            $request->file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $userId = auth()->id();

        $log = EconomicDataLog::create([
            'type_id' => EconomicDataLogType::WELL_FORECAST,
            'name' => $fileName,
            'author_id' => $userId,
            'is_processed' => false
        ]);

        (new TechnicalWellForecastImport($userId, $log->id))
            ->queue($request->file)
            ->chain([
                new TechnicalWellForecastSuccessImportJob($log->id),
            ]);

        return back()->with('success', __('app.success'));
    }
}

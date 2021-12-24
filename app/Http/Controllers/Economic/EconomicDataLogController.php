<?php

namespace App\Http\Controllers\Economic;


use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Log\EconomicDataLogRequest;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsAnalysisParam;
use App\Models\Refs\EcoRefsGtm;
use App\Models\Refs\EcoRefsGtmValue;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellForecastKit;
use App\Models\Refs\TechnicalWellForecastKitResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EconomicDataLogController extends Controller
{
    const PAGINATION = 100;

    public function index(EconomicDataLogRequest $request): View
    {
        $query = EconomicDataLog::query();

        if ($request->type_id) {
            $query->whereTypeId($request->type_id);
        }

        $logs = $query
            ->latest('id')
            ->paginate(self::PAGINATION);

        return view('economic.log.index', compact('logs'));
    }

    public function destroy(EconomicDataLog $log): RedirectResponse
    {
        DB::transaction(function () use ($log) {
            switch ($log->type_id) {
                case EconomicDataLogType::COST:
                    EcoRefsCost::query()->whereLogId($log->id)->delete();

                    break;
                case EconomicDataLogType::GTM:
                    EcoRefsGtm::query()->whereLogId($log->id)->delete();

                    break;
                case EconomicDataLogType::WELL_FORECAST:
                    $kitIds = TechnicalWellForecastKit::query()->whereTechnicalLogId($log->id)->pluck('id');

                    TechnicalWellForecastKit::query()->whereIn('id', $kitIds)->delete();

                    TechnicalWellForecastKitResult::query()->whereIn('kit_id', $kitIds)->delete();

                    TechnicalWellForecast::query()->whereLogId($log->id)->delete();

                    break;
                case EconomicDataLogType::ANALYSIS_PARAM:
                    $kitIds = TechnicalWellForecastKit::query()->whereEconomicLogId($log->id)->pluck('id');

                    TechnicalWellForecastKit::query()->whereIn('id', $kitIds)->delete();

                    TechnicalWellForecastKitResult::query()->whereIn('kit_id', $kitIds)->delete();

                    EcoRefsAnalysisParam::query()->whereLogId($log->id)->delete();

                    break;
                case EconomicDataLogType::DATA_FORECAST:
                    TechnicalDataForecast::query()->whereLogId($log->id)->delete();

                    break;
                case EconomicDataLogType::GTM_VALUE:
                    EcoRefsGtmValue::query()->whereLogId($log->id)->delete();

                    break;
            }

            $log->delete();
        });

        return redirect()
            ->back()
            ->with('success', __('app.deleted'));
    }

    public function getData(EconomicDataLogRequest $request): array
    {
        $query = EconomicDataLog::query();

        if ($request->type_id) {
            $query->whereTypeId($request->type_id);
        }

        if ($request->author_id) {
            $query->whereAuthorId($request->author_id);
        }

        if ($request->has('is_processed')) {
            $query->whereIsProcessed($request->is_processed);
        }

        return $query
            ->latest('id')
            ->get()
            ->toArray();
    }
}

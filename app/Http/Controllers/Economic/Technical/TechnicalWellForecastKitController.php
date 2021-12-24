<?php

namespace App\Http\Controllers\Economic\Technical;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Technical\WellForecast\Kit\TechnicalWellForecastKitDataRequest;
use App\Http\Requests\Economic\Technical\WellForecast\Kit\TechnicalWellForecastKitStoreRequest;
use App\Jobs\Economic\Technical\TechnicalWellForecastKitJob;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\TechnicalWellForecastKit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TechnicalWellForecastKitController extends Controller
{
    public function getData(TechnicalWellForecastKitDataRequest $request): array
    {
        $query = TechnicalWellForecastKit::query();

        if ($request->technical_log_id) {
            $query->whereTechnicalLogId($request->technical_log_id);
        }

        if ($request->economic_log_id) {
            $query->whereEconomicLogId($request->economic_log_id);
        }

        if ($request->is_processed) {
            $query->whereRaw(DB::raw("
                total_variants IS NOT NULL AND total_variants = calculated_variants
            "));
        }

        return $query
            ->with(['technicalLog', 'economicLog', 'user'])
            ->latest('id')
            ->get()
            ->toArray();
    }

    public function store(TechnicalWellForecastKitStoreRequest $request): TechnicalWellForecastKit
    {
        EconomicDataLog::query()
            ->where([
                'id' => $request->economic_log_id,
                'type_id' => EconomicDataLogType::ANALYSIS_PARAM
            ])
            ->firstOrFail();

        EconomicDataLog::query()
            ->where([
                'id' => $request->technical_log_id,
                'type_id' => EconomicDataLogType::WELL_FORECAST,
                'is_processed' => true
            ])
            ->firstOrFail();

        $kit = new TechnicalWellForecastKit($request->validated());

        $kit->permanent_stop_coefficients = $request->permanent_stop_coefficients;

        $kit->calculated_variants = 0;

        $kit->total_variants = count($kit->permanent_stop_coefficients);

        $kit->user_id = auth()->id();

        $kit->save();

        foreach ($kit->permanent_stop_coefficients as $coefficient) {
            dispatch(new TechnicalWellForecastKitJob(
                $kit->id,
                $coefficient['value']
            ));
        }

        return $kit;
    }

    public function destroy(Request $request): int
    {
        return DB::transaction(function () use ($request) {
            $kit = TechnicalWellForecastKit::query()
                ->whereId($request->kit_id)
                ->lockForUpdate()
                ->firstOrFail();

            $kit->results()->delete();

            return (int)$kit->delete();
        });
    }
}

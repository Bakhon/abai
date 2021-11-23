<?php

namespace App\Http\Controllers\Economic\Technical;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Technical\WellForecast\Kit\TechnicalWellForecastKitDataRequest;
use App\Http\Requests\Economic\Technical\WellForecast\Kit\TechnicalWellForecastKitStoreRequest;
use App\Models\Refs\TechnicalWellForecastKit;
use Illuminate\Http\Request;

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

        return $query
            ->with(['technicalLog', 'economicLog', 'user'])
            ->latest('id')
            ->get()
            ->toArray();
    }

    public function store(TechnicalWellForecastKitStoreRequest $request): TechnicalWellForecastKit
    {
        $kit = new TechnicalWellForecastKit($request->validated());

        $kit->user_id = auth()->id();

        $kit->save();

        return $kit;
    }

    public function destroy(Request $request): int
    {
        return (int)TechnicalWellForecastKit::query()
            ->whereId($request->kit_id)
            ->delete();
    }
}

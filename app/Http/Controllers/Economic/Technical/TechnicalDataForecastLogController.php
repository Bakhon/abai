<?php

namespace App\Http\Controllers\Economic\Technical;


use App\Http\Controllers\Controller;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalDataLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TechnicalDataForecastLogController extends Controller
{
    const PAGINATION = 10;

    public function index(): View
    {
        $logs = TechnicalDataLog::query()
            ->latest()
            ->paginate(self::PAGINATION);

        return view('economic.technical.forecast.log.index', compact('logs'));
    }

    public function destroy(int $id): RedirectResponse
    {
        TechnicalDataForecast::query()->whereLogId($id)->delete();

        TechnicalDataLog::query()->whereId($id)->delete();

        return redirect()
            ->route('economic.technical.forecast.index')
            ->with('success', __('app.deleted'));
    }
}

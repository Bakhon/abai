<?php

namespace App\Http\Controllers\Economic;


use App\Http\Controllers\Controller;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EconomicCostLogController extends Controller
{
    const PAGINATION = 10;

    public function index(): View
    {
        $economicDataLog = EconomicDataLog::query()
            ->latest()
            ->paginate(self::PAGINATION);

        return view('economic.cost.log.index', compact('economicDataLog'));
    }

    public function destroy(int $id): RedirectResponse
    {
        EcoRefsCost::query()->whereLogId($id)->delete();

        EconomicDataLog::query()->whereId($id)->delete();

        return redirect()
            ->route("economic.cost.index")
            ->with('success', __('app.deleted'));
    }
}

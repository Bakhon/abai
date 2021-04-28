<?php

namespace App\Http\Controllers\Refs;


use App\Http\Controllers\Controller;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use Illuminate\Http\RedirectResponse;

class EconomicDataLogController extends Controller
{
    const PAGINATION = 5;

    public function index()
    {
        $economicDataLog = EconomicDataLog::query()
            ->latest()
            ->paginate(self::PAGINATION);

        return view('eco_refs_cost.log.index', compact('economicDataLog'));
    }

    public function destroy(int $id): RedirectResponse
    {
        EcoRefsCost::query()->whereLogId($id)->delete();

        EconomicDataLog::query()->whereId($id)->delete();

        return redirect()
            ->route("economic_data_log.index")
            ->with('success', __('app.deleted'));
    }
}

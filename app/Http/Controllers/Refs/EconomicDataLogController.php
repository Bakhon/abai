<?php

namespace App\Http\Controllers\Refs;


use App\Http\Controllers\Controller;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EconomicDataLogController extends Controller
{
    const PAGINATION = 10;

    public function index(): View
    {
        $economicDataLog = EconomicDataLog::query()
            ->latest()
            ->paginate(self::PAGINATION);

        return view('economy_kenzhe/eco_refs_cost.log.index', compact('economicDataLog'));
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

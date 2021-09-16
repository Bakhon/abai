<?php

namespace App\Http\Controllers\Economic;


use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Log\EconomicLogIndexRequest;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsGtm;
use App\Models\Refs\EcoRefsGtmValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EconomicDataLogController extends Controller
{
    const PAGINATION = 10;

    public function index(EconomicLogIndexRequest $request): View
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
                case EconomicDataLogType::GTM_VALUE:
                    EcoRefsGtmValue::query()->whereLogId($log->id)->delete();

                    break;
            }
        });

        return redirect()
            ->back()
            ->with('success', __('app.deleted'));
    }
}

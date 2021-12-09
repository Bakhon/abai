<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Gtm\Kit\EconomicGtmKitDataRequest;
use App\Http\Requests\Economic\Gtm\Kit\EconomicGtmKitStoreRequest;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsGtmKit;
use Illuminate\Http\Request;

class EconomicGtmKitController extends Controller
{
    public function store(EconomicGtmKitStoreRequest $request): EcoRefsGtmKit
    {
        EconomicDataLog::query()
            ->where([
                'id' => $request->gtm_log_id,
                'type_id' => EconomicDataLogType::GTM
            ])
            ->firstOrFail();

        EconomicDataLog::query()
            ->where([
                'id' => $request->gtm_value_log_id,
                'type_id' => EconomicDataLogType::GTM_VALUE,
            ])
            ->firstOrFail();

        $kit = new EcoRefsGtmKit($request->validated());

        $kit->user_id = auth()->id();

        $kit->save();

        return $kit;
    }

    public function destroy(Request $request): int
    {
        return (int)EcoRefsGtmKit::query()
            ->whereId($request->kit_id)
            ->delete();
    }

    public function getData(EconomicGtmKitDataRequest $request): array
    {
        $query = EcoRefsGtmKit::query();

        if ($request->gtm_log_id) {
            $query->whereGtmLogId($request->gtm_log_id);
        }

        if ($request->gtm_value_log_id) {
            $query->whereGtmValueLogId($request->gtm_value_log_id);
        }

        return $query
            ->with(['gtmLog', 'gtmValueLog', 'user'])
            ->latest('id')
            ->get()
            ->toArray();
    }
}

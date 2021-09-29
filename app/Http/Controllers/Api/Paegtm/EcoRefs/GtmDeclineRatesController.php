<?php

namespace App\Http\Controllers\Api\Paegtm\EcoRefs;

use App\Http\Controllers\Controller;
use App\Models\Paegtm\EcoRefs\GtmDeclineRates;
use Illuminate\Http\Request;

class GtmDeclineRatesController extends Controller
{

    public function index($dzo, $year = null)
    {
        $query = GtmDeclineRates::query();

        $query->when(isset($year), function ($q) use ($year) {
            return $q->whereYear('date', $year);
        });

        $declineRates = $query->where('org_id', $dzo)->get();

        return response()->json($declineRates);
    }
}

<?php

namespace App\Http\Controllers\GTM;

use App\Http\Controllers\Controller;
use App\Models\Paegtm\TechEfficiency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AegtmController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:paegtm view main');
    }


    public function getComparisonTableData(Request $request): JsonResponse
    {
        $query = TechEfficiency::query();

        $query->select('uwi');

        $query->when($request->filled('dzoName'), function ($q) use ($request) {
            return $q->where('org_name_short', $request->dzoName);
        });

        $query->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request) {
            return $q->whereBetween('month', [
                $request->input('dateStart'),
                $request->input('dateEnd'),
            ]);
        });

        $result = $query->groupBy('uwi')->get();

        return response()->json($result);
    }
}

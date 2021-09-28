<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Models\BigData\Gtm;
use App\Models\BigData\WellWorkover;
use Illuminate\Http\Request;

class WellCardChart extends Controller
{
    public function getWellEvents(Request $request)
    {
        // $wellId = $request->get('wellId');
        $wellId = 2000000035234;
        
        $wellWorkoverKRS = WellWorkover::where('well', $wellId)->where('repair_type', 1)->get();
        $wellWorkoverPRS = WellWorkover::where('well', $wellId)->where('repair_type', 3)->get();
        $gtm = Gtm::where('well', $wellId)->get();

        return $gtm;
    }
}

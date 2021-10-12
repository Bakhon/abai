<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoPlan;
use Carbon\Carbon;

class ExcelFormPlansController extends Controller
{
    public function getPlansByDzo(Request $request)
    {
        return DzoPlan::query()
            ->whereYear('date', $request->year)
            ->where('dzo', $request->dzo)
            ->get();
    }
}

<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportOtm;
use Carbon\Carbon;

class ExcelFormOtmController extends Controller
{
    public function getDzoCurrentOtm(Request $request)
    {
        $currentMonthNumber = Carbon::now('Asia/Almaty')->month;
        $dzoName = $request->request->get('dzoName');

        $dzoOtmData = DzoImportOtm::query()
            ->whereMonth('date',$currentMonthNumber)
            ->where('dzo_name',$dzoName)
            ->first();

        return response()->json($dzoOtmData);
    }

    public function store(Request $request)
    {
        $currentMonthNumber = Carbon::now('Asia/Almaty')->month;
        $dzoName = $request->request->get('dzo_name');

        $currentChemistryRecord = DzoImportOtm::whereMonth('date', $currentMonthNumber)->where('dzo_name', $dzoName)->first();
        if (!is_null($currentChemistryRecord)) {
            $currentChemistryRecord->delete();
        }

        DzoImportOtm::create($request->request->all());
    }
}

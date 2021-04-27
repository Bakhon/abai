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

        $dzo_otm_data = new DzoImportOtm;
        $dzo_input_data = $request->request->all();

        foreach ($dzo_input_data as $key => $item) {
            $dzo_otm_data->$key = $dzo_input_data[$key];
        }

        $dzo_otm_data->save();
    }
}

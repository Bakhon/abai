<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportChemistry;
use Carbon\Carbon;

class ExcelFormChemistryController extends Controller
{
    public function getDzoCurrentChemistry(Request $request)
    {
        $currentMonthNumber = Carbon::now('Asia/Almaty')->month;
        $dzoName = $request->request->get('dzoName');

        $dzoChemistryData = DzoImportChemistry::query()
            ->whereMonth('date',$currentMonthNumber)
            ->where('dzo_name',$dzoName)
            ->first();

        return response()->json($dzoChemistryData);
    }

    public function store(Request $request)
        {
            $currentMonthNumber = Carbon::now('Asia/Almaty')->month;
            $dzoName = $request->request->get('dzo_name');

            $currentChemistryRecord = DzoImportChemistry::whereMonth('date', $currentMonthNumber)->where('dzo_name', $dzoName)->first();
            if (!is_null($currentChemistryRecord)) {
                $currentChemistryRecord->delete();
            }

            $dzo_chemistry_data = new DzoImportChemistry;
            $dzo_input_data = $request->request->all();
            foreach ($dzo_input_data as $key => $item) {
                $dzo_chemistry_data->$key = $dzo_input_data[$key];
            }

            $dzo_chemistry_data->save();
        }
}

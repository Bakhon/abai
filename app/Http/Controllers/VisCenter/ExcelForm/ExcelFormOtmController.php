<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportOtm;

class ExcelFormOtmController extends Controller
{
    public function store(Request $request)
    {
        $dzo_otm_data = new DzoImportOtm;
        $dzo_input_data = $request->request->all();

        foreach ($dzo_input_data as $key => $item) {
            $dzo_otm_data->$key = $dzo_input_data[$key];
        }

        $dzo_otm_data->save();
    }
}

<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportChemistry;

class ExcelFormChemistryController extends Controller
{
    public function store(Request $request)
        {
            $dzo_chemistry_data = new DzoImportChemistry;
            $dzo_input_data = $request->request->all();
            foreach ($dzo_input_data as $key => $item) {
                $dzo_chemistry_data->$key = $dzo_input_data[$key];
            }

            $dzo_chemistry_data->save();
        }
}

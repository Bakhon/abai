<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use App\Models\VisCenter\ExcelForm\DzoImportDecreaseReason;
use App\Models\VisCenter\ExcelForm\DzoImportField;
use Carbon\Carbon;

class ExcelFormController extends Controller
{
    public function store(Request $request)
    {
        $children_keys = array('downtimeReason' => 1, 'decreaseReason' => 2, 'fields' => 3);
        $dzo_summary_data = new DzoImportData;
        $dzo_data = $request->request->all();
        foreach ($dzo_data as $key => $item) {
            if (array_key_exists($key, $children_keys)) {
                continue;
            }
            $dzo_summary_data->$key = $dzo_data[$key];
        }

        $dzo_summary_data->save();
        $dzo_summary = DzoImportData::latest('id')->first();

        $fields_data = $request->request->get('fields');

        foreach ($fields_data as $field_name => $field) {
            $dzo_import_fields = new DzoImportField;
            $dzo_import_fields->importData()->associate($dzo_summary);
            $dzo_import_fields->field_name = $field_name;
            foreach($field as $item_name => $item) {
                $dzo_import_fields->$item_name = $field[$item_name];
            }
            $dzo_import_fields->save();
        }

        $dzo_downtime_reasons = new DzoImportDowntimeReason;
        $downtime_data = $request->request->get('downtimeReason');
        $dzo_downtime_reasons->importData()->associate($dzo_summary);
        foreach ($downtime_data as $key => $item) {
            $dzo_downtime_reasons->$key = $downtime_data[$key];
        }

        $dzo_downtime_reasons->save();

        $dzo_decrease_reasons = new DzoImportDecreaseReason;
        $decrease_data = $request->request->get('decreaseReason');
        $dzo_decrease_reasons->importData()->associate($dzo_summary);
        foreach ($decrease_data as $key => $item) {
            $dzo_decrease_reasons->$key = $decrease_data[$key];
        }

        $dzo_decrease_reasons->save();
    }
}

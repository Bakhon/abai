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
        $this->saveDzoSummaryData($request);
        $dzo_summary_last_record = DzoImportData::latest('id')->first();

        $this->saveDzoFieldsSummaryData($dzo_summary_last_record,$request);

        $dzo_downtime_reasons = new DzoImportDowntimeReason;
        $downtime_data = $request->request->get('downtimeReason');
        $dzo_downtime_reason = $this->getDzoChildSummaryData($dzo_downtime_reason,$downtime_data,$dzo_summary_last_record);
        $dzo_downtime_reason->save();

        $dzo_decrease_reasons = new DzoImportDecreaseReason;
        $decrease_data = $request->request->get('decreaseReason');
        $dzo_decrease_reason = $this->getDzoChildSummaryData($dzo_decrease_reason,$decrease_data,$dzo_summary_last_record);
        $dzo_decrease_reason->save();
    }

    public function saveDzoSummaryData($request)
    {
        $dzo_data = $request->request->all();
        $dzo_summary_data = $this->getDzoSummaryData($dzo_data);
        $dzo_summary_data->save();
    }

    public function getDzoSummaryData($dzo_input_data)
    {
        $children_keys = array('downtimeReason' => 1, 'decreaseReason' => 2, 'fields' => 3);
        $dzo_summary_data = new DzoImportData;
        foreach ($dzo_input_data as $key => $item) {
            if (array_key_exists($key, $children_keys)) {
                continue;
            }
            $dzo_summary_data->$key = $dzo_input_data[$key];
        }
        return $dzo_summary_data;
    }

    public function saveDzoFieldsSummaryData($dzo_summary_last_record,$request)
    {
        $fields_data = $request->request->get('fields');
        foreach ($fields_data as $field_name => $field) {
            $dzo_import_field_data = $this->getDzoFieldData($field_name,$dzo_summary_last_record,$field);
            $dzo_import_field_data->save();
        }
    }

    public function getDzoFieldData($field_name,$dzo_summary_last_record,$field)
    {
        $dzo_import_field = new DzoImportField;
        $dzo_import_field->importData()->associate($dzo_summary_last_record);
        $dzo_import_field->field_name = $field_name;
        foreach($field as $key => $item) {
            $dzo_import_field->$key = $field[$key];
        }
        return $dzo_import_field;
    }
    public function getDzoChildSummaryData($child_item,$dzo_input_data,$dzo_summary_last_record)
    {
        $child_item->importData()->associate($dzo_summary_last_record);
        foreach ($dzo_input_data as $key => $item) {
            $child_item->$key = $dzo_input_data[$key];
        }
        return $child_item;
    }
}

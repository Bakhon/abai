<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use App\Models\VisCenter\ExcelForm\DzoImportDecreaseReason;
use App\Models\VisCenter\ExcelForm\DzoImportField;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExcelFormController extends Controller
{

    public function getDzoCurrentData(Request $request)
    {
        $date = Carbon::yesterday('Asia/Almaty');
        if ($request->isCorrected) {
            $date = Carbon::parse($request->date)->addDays(1);
        }
        $dzoName = $request->request->get('dzoName');
        $dzoImportData = DzoImportData::query()
            ->whereDate('date',$date)
            ->where('dzo_name',$dzoName)
            ->whereNull('is_corrected')
            ->with('importField')
            ->with('importDowntimeReason')
            ->with('importDecreaseReason')
            ->first();

         if (is_null($dzoImportData)) {
            return response()->json($dzoImportData);
         }
         $dzoImportData->fields = $this->getFormattedFields($dzoImportData);

         return response()->json($dzoImportData);
    }

    public function getFormattedFields($dzoImportData)
    {
        return $dzoImportData->importField->mapWithKeys(function ($field) {
           return [$field['field_name'] => $field];
        });
    }

    public function store(Request $request)
    {
        $this->deleteAlreadyExistRecord($request);

        $this->saveDzoSummaryData($request);
        $dzo_summary_last_record = DzoImportData::latest('id')->whereNull('is_corrected')->first();

        $this->saveDzoFieldsSummaryData($dzo_summary_last_record,$request);

        $dzo_downtime_reason = new DzoImportDowntimeReason;
        $downtime_data = $request->request->get('downtimeReason');
        $dzo_downtime_reason = $this->getDzoChildSummaryData($dzo_downtime_reason,$downtime_data,$dzo_summary_last_record);
        $dzo_downtime_reason->save();

        $dzo_decrease_reason = new DzoImportDecreaseReason;
        $decrease_data = $request->request->get('decreaseReason');
        $dzo_decrease_reason = $this->getDzoChildSummaryData($dzo_decrease_reason,$decrease_data,$dzo_summary_last_record);
        $dzo_decrease_reason->save();
    }

    public function deleteAlreadyExistRecord($request)
    {
        $dzoName = $request->request->get('dzo_name');
        $recordDate = $request->request->get('date');
        $todayDzoImportDataRecord = DzoImportData::whereDate('date', Carbon::parse($recordDate))->where('dzo_name', $dzoName)->whereNull('is_corrected')->first();
        if ($this->isAlreadyUploaded($todayDzoImportDataRecord)) {
            DzoImportField::where('dzo_import_data_id',$todayDzoImportDataRecord->id)->delete();
            DzoImportDecreaseReason::where('dzo_import_data_id',$todayDzoImportDataRecord->id)->delete();
            DzoImportDowntimeReason::where('dzo_import_data_id',$todayDzoImportDataRecord->id)->delete();
            DzoImportData::where('id',$todayDzoImportDataRecord->id)->delete();
        }
    }

    public function isAlreadyUploaded($todayDzoImportDataRecord)
    {
        return !is_null($todayDzoImportDataRecord);
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

    public function storeCorrected(Request $request)
    {
        $this->saveDzoSummaryData($request);
        $dzo_summary_last_record = DzoImportData::latest('id')->where('is_corrected', true)->first();

        $this->saveDzoFieldsSummaryData($dzo_summary_last_record,$request);

        $dzo_downtime_reason = new DzoImportDowntimeReason;
        $downtime_data = $request->request->get('downtimeReason');
        $dzo_downtime_reason = $this->getDzoChildSummaryData($dzo_downtime_reason,$downtime_data,$dzo_summary_last_record);
        $dzo_downtime_reason->save();

        $dzo_decrease_reason = new DzoImportDecreaseReason;
        $decrease_data = $request->request->get('decreaseReason');
        $dzo_decrease_reason = $this->getDzoChildSummaryData($dzo_decrease_reason,$decrease_data,$dzo_summary_last_record);
        $dzo_decrease_reason->save();
    }

    public function getDailyProductionForApprove()
    {
        $forApprove = DzoImportData::query()
            ->where('is_corrected', true)
            ->with('importField')
            ->with('importDowntimeReason')
            ->with('importDecreaseReason')
            ->get()
            ->toArray();
        $forApproveDates = array_column($forApprove, 'date');
        $forApproveDzo = array_unique(array_column($forApprove, 'dzo_name'));
        $actual = DzoImportData::query()
             ->whereNull('is_corrected')
             ->where(function($q) use($forApproveDates) {
                 foreach ($forApproveDates as $date) {
                    $q->whereDate('date', '=', Carbon::parse($date), 'or');
                 }
             })
             ->whereIn('dzo_name',$forApproveDzo)
             ->with('importField')
             ->with('importDowntimeReason')
             ->with('importDecreaseReason')
             ->get()
             ->toArray();
        $comparedData = array (
            'forApprove' => $forApprove,
            'actual' => $actual
        );
        return $comparedData;
    }
}

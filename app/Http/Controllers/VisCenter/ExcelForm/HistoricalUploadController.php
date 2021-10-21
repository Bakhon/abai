<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use SimpleXLSX;

class HistoricalUploadController extends Controller
{
    private $fields = array();
    private $dzoName;
    private $type;
    private $operation = array (
        'create' => 0,
        'update' => 0
    );

    public function uploadHistoricalData()
    {
        return view('visualcenter.upload_historical_data');
    }

    public function storeHistoricalDataByDzo(Request $request)
    {
        $this->dzoName = $request->dzo;
        $this->type = $request->type;
        $parsedFile = SimpleXLSX::parseFile($request->file->getRealPath());
        if (!$parsedFile) {
            return 'Error!';
        }
        $summary = array();
        foreach($parsedFile->rows(0) as $rowIndex => $row) {
            if ($rowIndex === 0) {
               $this->fields = $this->getFieldKeys($row);
            } else {
               array_push($summary,$this->getFieldValues($row));
            }
        }
        $modelName = "App\Models\VisCenter\ExcelForm\\" . $request->type;
        $model = new $modelName();
        $this->store($model,$summary);
        return $this->operation;
    }

    private function getFieldKeys($row)
    {
        $keys = array();
        foreach($row as $index => $fieldName) {
            if ($fieldName !== '') {
               array_push($keys,$fieldName);
            }
        }
        return $keys;
    }

    private function getFieldValues($row)
    {
        $values = array(
            'dzo_name' => $this->dzoName
        );
        foreach($this->fields as $index => $fieldName) {
            if ($row[$index] !== '') {
                $values[$fieldName] = $row[$index];
            }
        }
        return $values;
    }


    private function store($model,$data)
    {
        foreach($data as $index => $dayData) {
            if ($this->type === 'DzoImportOtm') {
                $existRecord = $this->getRecordByOtm($model,$dayData);
            } else {
                $existRecord = $this->getRecord($model,$dayData);
            }

            if (is_null($existRecord)) {
                $this->operation['create'] += 1;
                $model->create($dayData);
            } else {
                $result = $existRecord->update($dayData);
                $this->operation['update'] += 1;
            }
            if ($index > 0 && $index % 10 == 0) {
                sleep(5);
            }
        }
    }

    private function getRecord($model,$data)
    {
        return $model::query()
            ->whereDate('date',Carbon::parse($data['date']))
            ->where('dzo_name',$this->dzoName)
            ->first();
    }

    private function getRecordByOtm($model,$data)
    {
        $date = Carbon::parse($data['date']);
        return $model::query()
            ->whereYear('date',$date->year)
            ->whereMonth('date',$date->month)
            ->where('dzo_name',$this->dzoName)
            ->first();
    }
}

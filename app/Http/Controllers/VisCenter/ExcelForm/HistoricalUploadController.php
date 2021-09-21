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

    public function uploadHistoricalData()
    {
        return view('visualcenter.upload_historical_data');
    }

    public function storeHistoricalDataByDzo(Request $request)
    {
        $this->dzoName = $request->dzo;
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
            $values[$fieldName] = $row[$index];
        }
        return $values;
    }


    private function store($model,$data)
    {
        foreach($data as $dayData) {
            $existRecord = $this->getRecord($model,$dayData);
            if (is_null($existRecord)) {
                $model->create($dayData);
            } else {
                $existRecord->update($dayData);
            }
        }
    }

    private function getRecord($model,$data)
    {
        return $model::query()
            ->whereDate('date',$data['date'])
            ->where('dzo_name',$this->dzoName)
            ->first();
    }
}

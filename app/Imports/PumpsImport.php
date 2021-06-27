<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Pump;
use App\Models\ComplicationMonitoring\Gu;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class PumpsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function transformDate($value, $format = 'd.m.Y')
{
    if(empty($value)){
        return null;
    }
    
    try {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return \Carbon\Carbon::createFromFormat($format, $value);
    }
}


    public function model(array $row)
    {
        $gu = Gu::where('name', '=', $row[0])->first();
        return new Pump([
            'gu_id' => empty($gu) ? null : $gu->id,
            'number' => $row[1],
            'model' => $row[2],
            'type' => $row[3],
            'perfomance' => $row[4],
            'power' => $row[5],
            'date_of_exploitation' => $this->transformDate($row[6]),
            'current_state' => $row[7],
            'date_of_repair' => $this->transformDate($row[8]),
            'type_of_repair' => $row[9],
        ]);

    }
}

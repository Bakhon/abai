<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Oven;
use App\Models\ComplicationMonitoring\Gu;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class OvensImport implements ToModel
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
        return new Oven([
            'gu_id' => empty($gu) ? null : $gu->id,
            'cipher' => $row[1],
            'type' => $row[2],
            'rated_heat_output' => $row[3],
            'date_of_exploitation' => $this->transformDate($row[4]),
            'current_state' => $row[5],
            'date_of_repair' => $this->transformDate($row[6]),
            'type_of_repair' => $row[7],
        ]);

    }
}

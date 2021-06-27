<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\BufferTank;
use App\Models\ComplicationMonitoring\Gu;
use Maatwebsite\Excel\Concerns\ToModel;

class BufferTankImport implements ToModel
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
        return new BufferTank([
            'gu_id' => empty($gu) ? null : $gu->id,
            'model' => $row[1],
            'name' => $row[2],
            'type' => $row[3],
            'volume' => $row[4],
            'date_of_exploitation' => $this->transformDate($row[5]),
            'current_state' => $row[6],
            'external_and_internal_inspection' => $this->transformDate($row[7]),
            'hydraulic_test' => $this->transformDate($row[8]),
            'date_of_repair' => $this->transformDate($row[9]),
            'type_of_repair' => $row[10],
        ]);

    }
}

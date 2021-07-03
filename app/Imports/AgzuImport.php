<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Agzu;
use App\Models\ComplicationMonitoring\Gu;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class AgzuImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    const GU = 0;
    const MODEL = 1;
    const METHOD_OF_MEASUREMENT = 2;
    const NUMBER_OF_CONNECTED_WELLS = 3;
    const DATE_OF_EXPLOITATION = 4;
    const CURRENT_STATE = 5;
    const DATE_OF_REPAIR = 6;
    const TYPE_OF_REPAIR = 7;


    public function transformDate($value, $format = 'd.m.Y')
{
    if(empty($value)){
        return null;
    }
    try {
        return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return Carbon::createFromFormat($format, $value);
    }
    
}



    public function model(array $row)
    {
        $gu = Gu::where('name', $row[self::GU])->first();
        return new Agzu([
            'gu_id' => empty($gu) ? null : $gu->id,
            'model' => $row[self::MODEL],
            'method_of_measurement' => $row[self::METHOD_OF_MEASUREMENT],
            'number_of_connected_wells' => $row[self::NUMBER_OF_CONNECTED_WELLS],
            'date_of_exploitation' => $this->transformDate($row[self::DATE_OF_EXPLOITATION]),
            'current_state' => $row[self::CURRENT_STATE],
            'date_of_repair' => $this->transformDate($row[self::DATE_OF_REPAIR]),
            'type_of_repair' => $row[self::TYPE_OF_REPAIR],
        ]);

    }
}

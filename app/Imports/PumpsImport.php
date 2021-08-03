<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Pump;
use App\Models\ComplicationMonitoring\Gu;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class PumpsImport implements ToModel
{
    const GU = 0;
    const NUMBER = 1;
    const MODEL = 2;
    const TYPE = 3;
    const PERFOMANCE = 4;
    const POWER = 5;
    const DATE_OF_EXPLOITATION = 6;
    const CURRENT_STATE = 7;
    const DATE_OF_REPAIR = 8;
    const TYPE_OF_REPAIR = 9;
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
        return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return Carbon::createFromFormat($format, $value);
    }
}


    public function model(array $row)
    {
        $gu = Gu::where('name', $row[self::GU])->first();
        return new Pump([
            'gu_id' => empty($gu) ? null : $gu->id,
            'number' => $row[self::NUMBER],
            'model' => $row[self::MODEL],
            'type' => $row[self::TYPE],
            'perfomance' => $row[self::PERFOMANCE],
            'power' => $row[self::POWER],
            'date_of_exploitation' => $this->transformDate($row[self::DATE_OF_EXPLOITATION]),
            'current_state' => $row[self::CURRENT_STATE],
            'date_of_repair' => $this->transformDate($row[self::DATE_OF_REPAIR]),
            'type_of_repair' => $row[self::TYPE_OF_REPAIR],
        ]);

    }
}

<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\BufferTank;
use App\Models\ComplicationMonitoring\Gu;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;


class BufferTankImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    const GU = 0;
    const MODEL = 1;
    const NAME = 2;
    const TYPE = 3;
    const VOLUME = 4;
    const DATE_OF_EXPLOITATION = 5;
    const CURRENT_STATE = 6;
    const EXTERNAL_AND_INTERNAL_INSPECTION = 7;
    const HYDRAULIC_TEST = 8;
    const DATE_OF_REPAIR = 9;
    const TYPE_OF_REPAIR = 10;

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
        return new BufferTank([
            'gu_id' => empty($gu) ? null : $gu->id,
            'model' => $row[self::MODEL],
            'name' => $row[self::NAME],
            'type' => $row[self::TYPE],
            'volume' => $row[self::VOLUME],
            'date_of_exploitation' => $this->transformDate($row[self::DATE_OF_EXPLOITATION]),
            'current_state' => $row[self::CURRENT_STATE],
            'external_and_internal_inspection' => $this->transformDate($row[self::EXTERNAL_AND_INTERNAL_INSPECTION]),
            'hydraulic_test' => $this->transformDate($row[self::HYDRAULIC_TEST]),
            'date_of_repair' => $this->transformDate($row[self::DATE_OF_REPAIR]),
            'type_of_repair' => $row[self::TYPE_OF_REPAIR],
        ]);

    }
}

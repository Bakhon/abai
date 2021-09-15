<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\ZusCLeaning;
use App\Models\ComplicationMonitoring\Zu;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ZuCleaningsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    const ZU = 0;
    const DATE = 1;
    const NUMBER_OF_FAILURES = 2;

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
        $zu = Zu::where('name', $row[self::ZU])->first();
        return new ZusCLeaning([
            'zu_id' => empty($zu) ? null : $zu->id,
            'date' => $this->transformDate($row[self::DATE]),
            'number_of_failures' => $row[self::NUMBER_OF_FAILURES],
        ]);

    }
}

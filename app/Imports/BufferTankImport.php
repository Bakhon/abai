<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportBufferTank;
use App\Models\ComplicationMonitoring\BufferTank;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\Ngdu;
use Maatwebsite\Excel\Concerns\ToModel;

class BufferTankImport implements ToModel
{
    public $command;

    const NGDU = 2;
    const GU = 4;
    const MODEL = 5;
    const NAME = 6;
    const TYPE = 7;
    const VOLUME = 8;
    const DATE_OF_EXPLOITATION = 9;
    const CURRENT_STATE = 10;
    const EXTERNAL_AND_INTERNAL_INSPECTION = 11;
    const HYDRAULIC_TEST = 12;
    const DATE_OF_REPAIR = 13;
    const TYPE_OF_REPAIR = 14;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct(ImportBufferTank $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function model(array $row)
    {
        $ngdu = Ngdu::where('name', '=',$row[self::NGDU])->first();
        $gu = Gu::where('name', '=',$row[self::GU])->first();
        return new BufferTank([
            'ngdu_id' => empty($ngdu) ? null : $ngdu->id,
            'gu_id' => empty($gu) ? null : $gu->id,
            'model' => $row[self::MODEL],
            'name' => $row[self::NAME],
            'type' => $row[self::TYPE],
            'volume' => $row[self::VOLUME],
            'date_of_exploitation' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[self::DATE_OF_EXPLOITATION]),
            'current_state' => $row[self::CURRENT_STATE],
            'external_and_internal_inspection' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[self::EXTERNAL_AND_INTERNAL_INSPECTION]),
            'hydraulic_test' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[self::HYDRAULIC_TEST]),
            'date_of_repair' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[self::DATE_OF_REPAIR]),
            'type_of_repair' => $row[self::TYPE_OF_REPAIR],
        ]);

        Log::info('row:'.$row);

    }
}



<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportBufferTank;
use App\Models\ComplicationMonitoring\BufferTank;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\Zu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Gu;
use App\Console\Commands\Import\Wells;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BufferTankImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    protected $gu;
    protected $ngdu;
    public $command;
    protected $errors = [];

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

    
    public function __construct(ImportBufferTank $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        if (strpos($this->sheetName, 'Буф.емкость') === 0) {
            $this->createBufferTankFields($this->sheetName, $collection);
            
            // $this->importGu($collection);
            // $this->importNgdu($collection);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                if (strpos($this->sheetName, 'Буф.емкость') !== 0) {
                    foreach ($this->errors as $error) {
                        $this->command->error($error);
                    }
                    throw new \Exception('Success import');
                }

                $this->ngdu = Ngdu::where('name', 'НГДУ-')->first();
                

                $this->command->line(' ');
                $this->command->line('----------------------------');
                $this->command->info('sheetName ' . $this->sheetName);
                $this->command->line('----------------------------');
                $this->command->line(' ');
            }
        ];
    }

    public function endColumn(): string
    {
        return 'T';
    }

    public function startRow(): int
    {
        return 2;
    }

    

    private function createBufferTankFields(string $bufferTank, Collection $collection)
    {
        foreach ($collection as $index => $row) {
            foreach ($row as $row_index => $value) {
                $row[$row_index] = str_replace(',','.', $row[$row_index]);
            }

        $bufferTank = new BufferTank;
        $bufferTank->gu_id = Gu::where('name', '=', $row[self::GU]);
        $bufferTank->ngdu_id = Ngdu::where('name', '=', $row[self::NGDU]);
        $bufferTank->model = $row[self::MODEL];
        $bufferTank->name = $row[self::NAME];
        $bufferTank->type = $row[self::TYPE];
        $bufferTank->volume = $row[self::VOLUME];
        $bufferTank->date_of_exploitation = Carbon::instance(Date::excelToDateTimeObject($row[self::DATE_OF_EXPLOITATION]))->format('Y-m-d');
        $bufferTank->current_state = $row[self::CURRENT_STATE];
        $bufferTank->external_and_internal_inspection = Carbon::instance(Date::excelToDateTimeObject($row[self::EXTERNAL_AND_INTERNAL_INSPECTION]))->format('Y-m-d');
        $bufferTank->hydraulic_test = Carbon::instance(Date::excelToDateTimeObject($row[self::HYDRAULIC_TEST]))->format('Y-m-d');
        $bufferTank->date_of_repair = Carbon::instance(Date::excelToDateTimeObject($row[self::DATE_OF_REPAIR]))->format('Y-m-d');
        $bufferTank->type_of_repair = $row[self::TYPE_OF_REPAIR];
        $bufferTank->save();
        $collection = $bufferTank;


    }

    


}
}

<?php

namespace App\Imports;

use App\Console\Commands\Import\PipePassports;
use App\Models\ComplicationMonitoring\PipePassport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PipePassportsImport implements ToCollection, WithEvents, WithColumnLimit, WithCalculatedFormulas
{
    public $sheetName;
    public $command;
    protected $errors = [];

    const FIELD = 0;
    const NGDU = 1;
    const CDNG = 2;
    const GU = 3;
    const NAME = 4;
    const IS_RESERVED = 5;
    const FROM = 6;
    const TO = 7;
    const LENGHT = 8;
    const DIAMETER = 9;
    const THICKNESS = 10;
    const MATERIAL = 11;
    const INSTALLATION_DATE = 12;
    const CONDITION = 13;
    const NUM_OF_GUSTS = 14;
    const PASS_DATASHEET = 15;
    const USED = 16;

    public function __construct(PipePassports $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        $this->importPipePassports($collection);
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                if (strpos($this->sheetName, 'НГДУ') !== 0) {
                    foreach ($this->errors as $error) {
                        $this->command->error($error);
                    }
                    throw new \Exception('Success import');
                }

                $this->command->line(' ');
                $this->command->line('----------------------------');
                $this->command->info('sheetName '.$this->sheetName);
                $this->command->line('----------------------------');
                $this->command->line(' ');
            }
        ];
    }

    public function endColumn(): string
    {
        return 'R';
    }

    private function importPipePassports(Collection $collection)
    {
        $collection = $collection->skip(3);

        foreach ($collection as $index => $row) {
            $pipe = new PipePassport;
            $pipe->field = $row[self::FIELD];
            $pipe->ngdu = $row[self::NGDU];
            $pipe->cdng = $row[self::CDNG];
            $pipe->gu = $row[self::GU];
            $pipe->name = $row[self::NAME];
            $pipe->main_reserved = $row[self::IS_RESERVED];

            $from = $row[self::FROM];
            if (preg_match("/^\d+$/", $from)) {
                $length = strlen($from);

                for ($i = 0; $i < (4 - $length); $i++) {
                    $from = '0'.$from;
                }

                $from = 'UZN_'.$from;
            }

            $pipe->from = $from;
            $pipe->to = $row[self::TO];
            $pipe->length = $row[self::LENGHT];
            $pipe->diameter = $row[self::DIAMETER];
            $pipe->thickness = $row[self::THICKNESS];
            $pipe->material = $row[self::MATERIAL];

            $installation_date = $row[self::INSTALLATION_DATE];

            if (strlen($installation_date) > 4) {
                $installation_date = Date::excelToDateTimeObject($installation_date)->format('Y-m-d');
            }

            $installation_date = Carbon::create($installation_date)->format('Y-m-d');
            $pipe->installation_date = $installation_date;
            $pipe->condition = $row[self::CONDITION];

            $gusts = $row[self::NUM_OF_GUSTS];
            if (!preg_match("/^\d+$/", $gusts)) {
                $pipe->comment = $gusts;
            } else {
                $pipe->gusts = $gusts;
            }

            if (strripos($row[self::PASS_DATASHEET], 'не') !== false || !$row[self::PASS_DATASHEET]) {
                $pipe->data_sheet = 0;
            } else {
                $pipe->data_sheet = 1;
            }

            $pipe->used = $row[self::USED];

            $pipe->save();
        }
    }
}

<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportCdngGuRelations;
use App\Models\Refs\Cdng;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\Refs\Ngdu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class CdngGuRelationsImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $command;

    const NGDU = 2;
    const CDNG = 5;
    const GU = 3;


    public function __construct(ImportCdngGuRelations $command)
    {
        $this->command = $command;
    }

    public function collection(Collection $collection)
    {
        $this->importCdngGuRelation($collection);
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

            }
        ];
    }

    public function endColumn(): string
    {
        return 'G';
    }

    private function importCdngGuRelation(Collection $collection)
    {
        $this->command->line('----------------------------');
        $this->command->info('Start Import relations between GU and CDNG');

        foreach ($collection as $index => $row) {
            if (!$row[self::NGDU] || !$row[self::CDNG] || !$row[self::GU]) {
                continue;
            }

            $ngdu = Ngdu::where('name', $row[self::NGDU])->first();

            $cdng = Cdng::firstOrCreate(
                [
                    'name' => $row[self::CDNG]
                ]
            );

            $cdng->ngdu_id = $ngdu->id;
            $cdng->save();

            $gu = Gu::where('name', $row[self::GU])->first();

            if ($gu) {
                $gu->cdng_id = $cdng->id;
                $gu->save();
            }
        }

        $this->command->info('Import relations between GU and CDNG finished');
        $this->command->line('----------------------------');
        $this->command->line(' ');
    }

    public function startRow(): int
    {
        return 2;
    }
}


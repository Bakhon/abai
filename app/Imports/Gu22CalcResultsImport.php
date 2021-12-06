<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportGu22CalcResults;
use App\Models\ComplicationMonitoring\HydroCalcLong;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\OilPipe;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class Gu22CalcResultsImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    protected $shortSchema = [
        'length' => 0,
        'qliq' => 1,
        'bsw' => 2,
        'gazf' => 3,
        'press_start' => 4,
        'press_end' => 5,
        'temperature_start' => 6,
        'temperature_end' => 7,
        'start_point' => 8,
        'end_point' => 9,
        'name' => 10,
        'mix_speed_avg' => 11,
        'fluid_speed' => 12,
        'gaz_speed' => 13,
        'flow_type' => 14,
        'press_change' => 15,
        'break_qty' => 16,
        'height_drop' => 17
    ];

    protected $longSchema = [
        'pipe_name' => 0,
        'segment' => 1,
        'distance' => 2,
        'pin' => 3,
        'pout' => 4,
        'tin' => 5,
        'tout' => 6,
        'ev' => 7,
        'vliq' => 8,
        'vgas' => 9,
        'vm' => 10,
        'comment' => 11
    ];

    public function __construct(ImportGu22CalcResults $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                $this->command->line(' ');
                $this->command->line('----------------------------');
                $this->command->info('sheetName ' . $this->sheetName);
                $this->command->line('----------------------------');
                $this->command->line(' ');
            }
        ];
    }

    public function collection(Collection $collection)
    {
        if ($this->sheetName == 'short') {
            $this->importShortCalcResults($collection);
        } else {
            $this->importLongCalcResults($collection);
        }

        $this->command->info('Import Finished');
    }

    public function endColumn(): string
    {
        return 'S';
    }

    private function importShortCalcResults(Collection $collection)
    {
        $collection = $collection->skip(1);
        $this->command->info('Start Short results');

        foreach ($collection as $row) {
            $pipe = OilPipe::where('name', $row[$this->shortSchema['name']])->first();
            $calcResult = HydroCalcResult::firstOrCreate(
                [
                    'date' => '2021-12-02',
                    'oil_pipe_id' => $pipe->id,
                ]
            );

            foreach ($this->shortSchema as $param => $index) {
                if ($param == 'name') {
                    continue;
                }

                $calcResult->$param = $row[$index];
            }

            $calcResult->save();

            $this->command->info($row[$this->shortSchema['name']] . ' Imported');
        }

        $this->command->info('=====================');
        $this->command->info('Short results Imported');
        $this->command->info('=====================');
    }

    private function importLongCalcResults(Collection $collection)
    {
        $pipe = null;
        $collection = $collection->skip(1);
        $this->command->info('Start long results');

        foreach ($collection as $row) {

            if (!$pipe || $pipe->name != $row[$this->longSchema['pipe_name']]) {
                $pipe = OilPipe::where('name', $row[$this->longSchema['pipe_name']])->first();
            }

            $hydroCalcLong = HydroCalcLong::firstOrCreate(
                [
                    'date' => '2021-12-02',
                    'oil_pipe_id' => $pipe->id,
                    'segment' => $row[$this->longSchema['segment']]
                ]
            );

            foreach ($this->longSchema as $param => $index) {
                if ($param == 'pipe_name') {
                    continue;
                }

                $hydroCalcLong->$param = $row[$index];
            }

            $hydroCalcLong->save();

            $this->command->info($row[$this->longSchema['pipe_name']] .' '.$row[$this->longSchema['segment']].' Imported');
        }

        $this->command->info('=====================');
        $this->command->info('Long results Imported');
        $this->command->info('=====================');
    }

    public function startRow(): int
    {
        return 1;
    }
}

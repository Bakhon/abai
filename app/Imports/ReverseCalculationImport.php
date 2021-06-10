<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportReverseCalculation;
use App\Models\ComplicationMonitoring\ReverseCalculation;
use App\Models\ComplicationMonitoring\OilPipe;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;

class ReverseCalculationImport implements ToCollection, WithEvents, WithColumnLimit, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const NUMBER = 0;
    const OUT_DIAMETR = 1;
    const WALL_THICKNESS = 2;
    const LENGTH = 3;
    const QLIQ = 4;
    const BSW = 5;
    const GAS_FACTOR = 6;
    const PRESSURE_START = 7;
    const PRESSURE_END = 8;
    const TEMPERATURE_START = 9;
    const TEMPERATURE_END = 10;
    const START_POINT = 11;
    const END_POINT = 12;
    const NAME = 13;
    const MIX_SPEED_AVERAGE = 14;
    const FLUID_SPEED = 15;
    const GAS_SPEED = 16;
    const FLOW_TYPE = 17;
    const PRESS_CHANGE = 18;
    const BREAK_QTY = 19;
    const HEIGHT_DROP = 20;

    public function __construct(ImportReverseCalculation $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        if (strpos($this->sheetName, 'reverse_calculation') !== false) {
            $this->importPoints($collection);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                if (strpos($this->sheetName, 'reverse_calculation') === false) {
                    throw new \Exception('Success import');
                }

                $this->command->line(' ');
                $this->command->line('----------------------------');
                $this->command->info('sheet name '.$this->sheetName);
                $this->command->line('----------------------------');
                $this->command->line(' ');
            }
        ];
    }

    public function endColumn(): string
    {
        return 'V';
    }

    private function importPoints(Collection $collection)
    {
        $collection = $collection->skip(2);

        foreach ($collection as $row) {
            $calculation = new ReverseCalculation();
            $calculation->date = '2021-04-19';
            $calculation->outside_diameter = $row[self::OUT_DIAMETR];
            $calculation->thickness = $row[self::WALL_THICKNESS];
            $calculation->length = $row[self::LENGTH];
            $calculation->daily_fluid_production = $row[self::QLIQ];
            $calculation->bsw = $row[self::BSW];
            $calculation->gas_factor = $row[self::GAS_FACTOR];
            $calculation->pressure_start = $row[self::PRESSURE_START];
            $calculation->pressure_end = $row[self::PRESSURE_END];
            $calculation->temperature_start = $row[self::TEMPERATURE_START];
            $calculation->temperature_end = $row[self::TEMPERATURE_END];
            $calculation->start_point = $row[self::START_POINT];
            $calculation->end_point = $row[self::END_POINT];

            $oilPipe = OilPipe::where('start_point', $row[self::START_POINT])
                ->where('end_point', $row[self::END_POINT])
                ->first();

            if (!$oilPipe) {
                $message = 'There no pipe. Start Point :'.$row[self::START_POINT].', End Point '.$row[self::END_POINT];
                $this->command->error($message);
                break;
            }

            $calculation->oil_pipe_id = $oilPipe->id;
            $calculation->name = $row[self::NAME];
            $calculation->mix_speed_avg = $row[self::MIX_SPEED_AVERAGE];
            $calculation->fluid_speed = $row[self::FLUID_SPEED];
            $calculation->gaz_speed = $row[self::GAS_SPEED];
            $calculation->flow_type = $row[self::FLOW_TYPE];
            $calculation->press_change = $row[self::PRESS_CHANGE];
            $calculation->break_qty = $row[self::BREAK_QTY] ? $row[self::BREAK_QTY] : null;
            $calculation->height_drop = $row[self::HEIGHT_DROP] ? $row[self::HEIGHT_DROP] : null;
            $calculation->save();
        }

        throw new \Exception('Success import');
    }
}

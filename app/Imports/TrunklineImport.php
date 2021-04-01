<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\PipeType;
use App\Models\Pipes\MapPipe;
use App\Models\Pipes\PipeCoord;
use App\Models\Refs\Ngdu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;

class TrunklineImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    protected $gu;
    public $command;
    protected $errors = [];
    protected $ngdu;

    const PIPE_START_NAME = 0;
    const H_DISTANCE = 1;
    const M_DISTANCE = 2;
    const LAT = 3;
    const LON = 4;
    const ELEVATION = 5;
    const INNER_DIAMETER = 6;
    const THICKNESS = 7;
    const ROUGHNESS = 8;
    const OUTSIDE_DIAMETER = 9;
    const END_PIPE = 10;

    const REGULARS = [
        'fl-koll' => '/fl/i',
        'gu-koll' => '/gu/i',
        'mgu-koll' => '/mgu/i',
        'koll-bg' => '/koll.+bg/i',
        'os-st' => '/os.+st/i',
        'bg-gu' => '/bg.+gu/i',
        'bg' => '/bg/i',
        'koll-koll' => '/koll/i',
        'st-koll' => '/st/i',
        'spt-koll' => '/spt/i'
    ];


    public function __construct(\App\Console\Commands\Import\ImportTrunkline $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        $this->importTrunkline($collection);
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                if (strpos($this->sheetName, 'НГДУ') === 0) {
                    $this->ngdu = Ngdu::where('name', $this->sheetName)->first();

                    $between_points = [];
                    foreach (self::REGULARS as $key => $regular) {
                        $between_points[] = $key;
                    }

                    MapPipe::where('ngdu_id', $this->ngdu->id)->whereIn('between_points', $between_points)->delete();
                }

                if (strpos($this->sheetName, 'НГДУ') !== 0) {
                    foreach ($this->errors as $error) {
                        $this->command->error($error);
                    }
                    throw new \Exception('Stop import');
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
        return 'L';
    }

    private function importTrunkline(Collection $collection)
    {
        if (!$this->dataIsValid($collection)) {
            return;
        }

        $collection = $collection->skip(1);

        $pipe = null;

        $this->command->line('----------------------------');
        $this->command->info('Processing '.$this->ngdu->name.' trunkline');

        foreach ($collection as $index => $row) {

            if ($row[self::LAT] == null && $row[self::LON] == null) {
                $message = $row[self::PIPE_START_NAME].' Pipe, '.$this->ngdu->name.' There no coordinates';
                $this->command->error($message);
                break;
            }

            $row[self::LAT] = str_replace(',','.', $row[self::LAT]);
            $row[self::LON] = str_replace(',','.', $row[self::LON]);

            if (!empty($row[self::PIPE_START_NAME])) {
                $pipe_type = $this->createPipeType($row);

                $this->command->info('Create Pipe '.$row[self::PIPE_START_NAME]);
                $pipe = MapPipe::firstOrCreate(
                    [
                        'name' => $row[self::PIPE_START_NAME],
                        'ngdu_id' => $this->ngdu->id
                    ]
                );

                $pipe->type_id = $pipe_type->id;
                $pipe->between_points = $this->getPipeType($row);
                $pipe->save();
            }

            $this->createPipeCoord($row, $pipe->id);
        }

        $this->command->info($this->ngdu->name.' Finished');
        $this->command->line('----------------------------');
        $this->command->line(' ');
    }

    private function dataIsValid(Collection $collection)
    {
        $header = $collection->first();
        if ($header[0] !== 'Well#') {
            return false;
        }
        if ($header[3] !== 'Latitude (deg)') {
            return false;
        }
        if ($header[4] !== 'Longitude (deg)') {
            return false;
        }

        return true;
    }

    public function startRow(): int
    {
        return 2;
    }

    private function createPipeType($row): PipeType
    {
        $this->command->info('Create Pipe Type');
        $roughness = str_replace(',', '.', $row[self::ROUGHNESS]);
        $roughness = floatval($roughness);

        return PipeType::firstOrCreate(
            [
                'outside_diameter' => $row[self::OUTSIDE_DIAMETER],
                'inner_diameter' => $row[self::INNER_DIAMETER],
                'thickness' => $row[self::THICKNESS],
                'roughness' => $roughness
            ]
        );
    }


    private function createPipeCoord($row, int $map_pipe_id): void
    {
        $pipe_coords = new PipeCoord;
        $pipe_coords->map_pipe_id = $map_pipe_id;
        $pipe_coords->lat = $row[self::LAT];
        $pipe_coords->lon = $row[self::LON];
        $pipe_coords->elevation = $row[self::ELEVATION];
        $pipe_coords->h_distance = $row[self::H_DISTANCE];
        $pipe_coords->m_distance = $row[self::M_DISTANCE];
        $pipe_coords->save();
    }


    private function getPipeType ($row)
    {
        foreach (self::REGULARS as $type => $regular) {
            if (preg_match($regular, $row[self::PIPE_START_NAME])) {
                return $type;
            }
        }
    }

}
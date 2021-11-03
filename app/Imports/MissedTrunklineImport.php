<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportMissedTrunkline;
use App\Console\Commands\Import\Wells;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\Material;
use App\Models\ComplicationMonitoring\PipeType;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\Ngdu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;

class MissedTrunklineImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    protected $gu;
    public $command;
    protected $errors = [];
    protected $ngdu;

    const COLUMNS = [
        'pipe_name' => 0,
        'h_distance' => 1,
        'm_distance' => 2,
        'lat' => 3,
        'lon' => 4,
        'elevation' => 5,
        'inner_diameter' => 6,
        'roughness' => 7,
        'ngdu' => 8,
        'gu' => 9,
        'outside_diameter' => 10,
        'thickness' => 11,
        'start_point' => 12,
        'end_point' => 13,
        'pipe_end' => 14
    ];

    const REGULARS = [
        'koll-koll' => '/&/i',
        'fl-koll' => '/fl/i',
        'gu-koll' => '/gu/i',
        'mgu-koll' => '/mgu/i',
        'koll-bg' => '/koll.+bg/i',
        'os-st' => '/os.+st/i',
        'bg-gu' => '/bg.+gu/i',
        'bg' => '/bg/i',
        'st-koll' => '/st/i',
        'spt-koll' => '/spt/i'
    ];


    public function __construct(ImportMissedTrunkline $command)
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
        return 'P';
    }

    private function importTrunkline(Collection $collection)
    {
        $collection = $collection->skip(1);

        $pipe = null;

        foreach ($collection as $row) {
            foreach (self::COLUMNS as $COLUMN) {
                $row[$COLUMN] = str_replace(',', '.', $row[$COLUMN]);
            }

            if (!empty($row[self::COLUMNS['pipe_name']]) && !$pipe) {
                $this->command->line('----------------------------');
                $this->command->info('Processing ' . $row[self::COLUMNS['pipe_name']] . ' pipe');

                $this->deleteOldPipe($row);

                $pipe_type = $this->createPipeType($row);
                $roughness = floatval($row[self::COLUMNS['roughness']]);
                $material = Material::where('roughness', $roughness)->first();

                $ngdu = Ngdu::where('name', $row[self::COLUMNS['ngdu']])->first();
                $gu = Gu::where('name', $row[self::COLUMNS['gu']])->first();

                $pipe = OilPipe::firstOrNew(
                    [
                        'name' => $row[self::COLUMNS['start_point']] . '-' . $row[self::COLUMNS['end_point']],
                        'ngdu_id' => $ngdu->id
                    ]
                );

                $pipe->type_id = $pipe_type->id;
                $pipe->material_id = $material->id;
                $pipe->between_points = $this->getPipeType($row);
                $pipe->start_point = $row[self::COLUMNS['start_point']];
                $pipe->end_point = $row[self::COLUMNS['end_point']];
                $pipe->gu_id = $gu ? $gu->id : null;

                $pipe->save();
                $this->command->info('Pipe created '.$row[self::COLUMNS['start_point']] . '-' . $row[self::COLUMNS['end_point']]);
                PipeCoord::where('oil_pipe_id', $pipe->id)->forceDelete();
            }

            $this->command->info('Create Pipe '.$pipe->name.' Coords');
            $this->createPipeCoord($row, $pipe->id);

            if ($row[self::COLUMNS['pipe_end']]) {
                $pipe = null;
            }
        }

        $this->command->info($row[self::COLUMNS['pipe_name']] . ' Finished');
        $this->command->line('----------------------------');
        $this->command->line(' ');
    }

    public function startRow(): int
    {
        return 1;
    }

    private function createPipeType($row): PipeType
    {
        $this->command->info('Create Pipe Type if not exists');
        $thickness = ($row[self::COLUMNS['outside_diameter']] - $row[self::COLUMNS['inner_diameter']]) / 2;


        $pipeType = PipeType::firstOrCreate(
            [
                'outside_diameter' => $row[self::COLUMNS['outside_diameter']],
                'inner_diameter' => $row[self::COLUMNS['inner_diameter']],
                'thickness' => $thickness
            ]
        );

        $pipeType->name = (int)$row[self::COLUMNS['outside_diameter']] . 'x' . (int)$thickness;
        $pipeType->save();

        return $pipeType;
    }


    private function createPipeCoord($row, int $oilPipeId): void
    {
        $pipe_coords = new PipeCoord;
        $pipe_coords->oil_pipe_id = $oilPipeId;
        $pipe_coords->lat = $row[self::COLUMNS['lat']];
        $pipe_coords->lon = $row[self::COLUMNS['lon']];
        $pipe_coords->elevation = $row[self::COLUMNS['elevation']];
        $pipe_coords->h_distance = $row[self::COLUMNS['h_distance']];
        $pipe_coords->m_distance = $row[self::COLUMNS['m_distance']];
        $pipe_coords->save();
    }

    private function deleteOldPipe($row)
    {
        $old_pipe = OilPipe::where('name', $row[self::COLUMNS['pipe_name']])->first();
        PipeCoord::where('oil_pipe_id', $old_pipe->id)->forceDelete();
        $old_pipe->forceDelete();
    }


    private function getPipeType($row)
    {
        foreach (self::REGULARS as $type => $regular) {
            if (preg_match($regular, $row[self::COLUMNS['pipe_name']])) {
                return $type;
            }
        }
    }

}

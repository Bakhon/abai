<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportPS;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\Material;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\PipeType;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class ImportPsPipesObjects implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    protected $gu;
    public $command;
    protected $ngdu_name = 'НГДУ-3';
    protected $ngdu;

    const COLUMNS = [
        'pipe_name' => 0,
        'h_distance' => 1,
        'm_distance' => 2,
        'lat' => 3,
        'lon' => 4,
        'elevation' => 5,
        'inner_diameter' => 6,
        'thickness' => 7,
        'roughness' => 8,
        'gu' => 9,
        'outside_diameter' => 10,
        'start_point' => 11,
        'end_point' => 12,
        'pipe_end' => 13,
        'between_points' => 14
    ];


    public function __construct(ImportPS $command)
    {
        $this->command = $command;
        $this->sheetName = null;
        $this->ngdu = Ngdu::where('name', $this->ngdu_name)->first();
    }

    public function collection(Collection $collection)
    {
        $this->importPs($collection);
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

    private function importPs(Collection $collection)
    {
        $collection = $collection->skip(1);

        $pipe = $well = $zu = null;

        foreach ($collection as $row) {
            foreach (self::COLUMNS as $COLUMN) {
                $row[$COLUMN] = str_replace(',', '.', $row[$COLUMN]);
            }

            if (!empty($row[self::COLUMNS['pipe_name']]) && !$pipe) {
                $gu = Gu::firstOrCreate(
                    ['name' => $row[self::COLUMNS['gu']]]
                );


                if ($row[self::COLUMNS['between_points']] == 'well-zu' ||
                    $row[self::COLUMNS['between_points']] == 'well-collector'
                ) {
                    $well = $this->createWell($row, $gu);
                }

                $pipe = $this->createNewPipe($row);
            }

            $this->createPipeCoord($row, $pipe->id);

            if ($row[self::COLUMNS['pipe_end']]) {
                switch ($row[self::COLUMNS['between_points']]) {
                    case 'well-zu':
                    case 'well_collector-zu':
                        $zu = $this->createZu($row, $gu);

                        if ($well) {
                            $well->zu_id = $zu->id;
                            $well->save();
                        }
                        break;

                    case 'zu-gu':
                    case 'zu_coll-gu':
                        $gu->lat = $row[self::COLUMNS['lat']];
                        $gu->lon = $row[self::COLUMNS['lon']];
                        $gu->elevation = $row[self::COLUMNS['elevation']];
                        $gu->ngdu_id = $this->ngdu->id;
                        $gu->save();
                }

                $pipe->well_id = $well ? $well->id : null;
                $pipe->zu_id = $zu ? $zu->id : null;
                $pipe->gu_id = $gu->id;
                $pipe->ngdu_id = $this->ngdu->id;
                $pipe->save();

                $pipe = $well = $zu = null;
            }
        }

        $this->command->info($row[self::COLUMNS['pipe_name']] . ' Finished');
        $this->command->line('----------------------------');
        $this->command->line(' ');
    }

    public function createNewPipe($row)
    {
        $this->command->line('----------------------------');
        $this->command->info('Processing ' . $row[self::COLUMNS['pipe_name']] . ' pipe');

        $this->deleteOldPipe($row);

        $pipe_type = $this->createPipeType($row);
        $roughness = floatval($row[self::COLUMNS['roughness']]);
        $material = Material::where('roughness', $roughness)->first();

        $gu = Gu::firstOrCreate(
            ['name' => $row[self::COLUMNS['gu']]]
        );

        $pipe = OilPipe::firstOrNew(
            [
                'name' => $row[self::COLUMNS['pipe_name']],
                'ngdu_id' => $this->ngdu->id,
                'gu_id' => $gu->id
            ]
        );

        $pipe->type_id = $pipe_type->id;
        $pipe->material_id = $material->id;
        $pipe->between_points = $row[self::COLUMNS['between_points']];
        $pipe->start_point = $row[self::COLUMNS['start_point']];
        $pipe->end_point = $row[self::COLUMNS['end_point']];

        $pipe->save();
        $this->command->info('Pipe created ' . $row[self::COLUMNS['start_point']] . '-' . $row[self::COLUMNS['end_point']]);
        PipeCoord::where('oil_pipe_id', $pipe->id)->forceDelete();

        return $pipe;
    }

    public function createZu($row, $gu): Zu
    {
        $this->command->info('Create if not exists ZU ' . $row[self::COLUMNS['end_point']]);

        $zu = Zu::firstOrNew(
            [
                'name' => $row[self::COLUMNS['end_point']]
            ]
        );

        $zu->lat = $row[self::COLUMNS['lat']];
        $zu->lon = $row[self::COLUMNS['lon']];
        $zu->elevation = $row[self::COLUMNS['elevation']];
        $zu->gu_id = $gu->id;
        $zu->ngdu_id = $this->ngdu->id;
        $zu->save();

        return $zu;
    }

    public function createWell($row, $gu): Well
    {
        $this->command->info('Create Well ' . $row[self::COLUMNS['start_point']]);

        $well = Well::firstOrNew(
            [
                'name' => $row[self::COLUMNS['start_point']],
                'ngdu_id' => $this->ngdu->id,
                'gu_id' => $gu->id
            ]
        );

        $well->zu_id = 0;
        $well->lat = $row[self::COLUMNS['lat']];
        $well->lon = $row[self::COLUMNS['lon']];
        $well->elevation = $row[self::COLUMNS['elevation']];
        $well->save();

        return $well;
    }

    public function startRow(): int
    {
        return 1;
    }

    private function createPipeType($row): PipeType
    {
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
        $old_pipe = OilPipe::where('name', $row[self::COLUMNS['pipe_name']])
            ->where('ngdu_id', $this->ngdu->id)->first();
        if ($old_pipe) {
            PipeCoord::where('oil_pipe_id', $old_pipe->id)->forceDelete();
            $old_pipe->forceDelete();
        }
    }

}

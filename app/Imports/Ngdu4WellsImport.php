<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\PipeType;
use App\Models\Pipes\MapPipe;
use App\Models\Pipes\PipeCoord;
use App\Models\Refs\Ngdu;
use App\Models\Refs\Zu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;
use App\Models\Refs\Well;
use App\Models\Refs\Gu;
use App\Console\Commands\Import\Ngdu4Wells;

class Ngdu4WellsImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    protected $gu;
    public $command;
    protected $errors = [];

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
    const PIPE_NAME = 10;
    const WELL_NAME = 11;
    const GU = 12;
    const ZU = 13;
    const COLOR = 14;
    const END_PIPE = 15;
    const OUTSIDE_LINE = 16;
    const COLLECTOR = 17;
    const WELL_NUMBER = 18;

    const BETWEEN_POINTS_ARRAY = [
        'well-zu',
        'fl-zu',
        'well-collector',
        'gu',
        'zu-gu'
    ];

    public function __construct(Ngdu4Wells $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        if (strpos($this->sheetName, 'НГДУ-4') === 0) {
            $this->importGu($collection);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                if (strpos($this->sheetName, 'НГДУ-4') !== 0) {
                    foreach ($this->errors as $error) {
                        $this->command->error($error);
                    }
                    throw new \Exception('Success import');
                }

                $this->ngdu = Ngdu::where('name', 'НГДУ-4')->first();
                MapPipe::where('ngdu_id', $this->ngdu->id)->whereIn('between_points', self::BETWEEN_POINTS_ARRAY)->delete();
                Well::where('ngdu_id', $this->ngdu->id)->delete();

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

    private function importGu(Collection $collection)
    {
        $well = null;
        $between_points = null;
        $pipe = null;
        $zu = null;
        $guName = null;

        foreach ($collection as $index => $row) {
            if ($row[self::LAT] == null && $row[self::LON] == null) {
                $message = $row[self::GU].', Pipe '.$row[self::PIPE_NAME].' There no coordinates';
                $this->command->error($message);
                break;
            }

            $row[self::LAT] = str_replace(',','.', $row[self::LAT]);
            $row[self::LON] = str_replace(',','.', $row[self::LON]);

            if ($guName != $row[self::GU]) {
                if ($guName !== null) {
                    $this->command->line(' ');
                    $this->command->line('----------------------------');
                    $this->command->info($guName . ' Finished');
                    $this->command->line('----------------------------');
                    $this->command->line(' ');
                }

                $guName = $row[self::GU];

                $this->gu = Gu::firstOrCreate(
                    [
                        'name' => strtoupper($guName)
                    ]
                );

                $this->command->line('----------------------------');
                $this->command->info('Processing ' . $guName);
                $this->command->line('----------------------------');
                $this->command->line(' ');
            }

            if (!empty($row[self::PIPE_START_NAME])) {
                $pipe_type = $this->createPipeType($row);

                $this->command->info('Create Pipe ' . $row[self::PIPE_NAME]);
                $pipe = MapPipe::firstOrCreate(
                    [
                        'name' => $row[self::PIPE_NAME],
                        'ngdu_id' => $this->ngdu->id,
                        'gu_id' => $this->gu->id
                    ]
                );
                PipeCoord::where('map_pipe_id', $pipe->id)->delete();
                $pipe->type_id = $pipe_type->id;

                $between_points = $this->getPipeType($row);

                if ($between_points == 'well-zu') {
                    $well = $this->createWell($row);
                }

                if ($between_points == 'zu-gu') {
                    $zu = Zu::where('lat', $row[self::LAT])->where('lon', $row[self::LON])->first();
                    if ($zu) {
                        $pipe->zu_id = $zu->id;
                    }
                }

                $pipe->gu_id = $this->gu->id;
                $pipe->between_points = $between_points;
                $pipe->save();
            }

            if ($row[self::END_PIPE]) {
                $pipe->color = '[0,255,0]';

                if ($between_points == 'well-zu') {
                    if (!$row[self::ZU]) {
                        $zu = Zu::where('lat', $row[self::LAT])->where('lon', $row[self::LON])->first();

                        if (!$zu) {
                            $message = 'Отсутсвует имя ЗУ, в ' . $this->gu->name . ', скважина ' . $well->name;

                            Log::channel('exel_import')->info($message);
                            $this->command->error($message);

                            $this->errors[] = $message;

                            PipeCoord::where('map_pipe_id', $pipe->id)->delete();
                            $pipe->delete();

                            $zu = $well = $pipe = $pipe_coords = $between_points = null;
                            continue;
                        } else {
                            $row[self::ZU] = $zu->name;
                        }
                    }

                    if (preg_match('/ГУ/i', $row[self::ZU])) {
                        $between_points = 'zu-gu';
                    } else {
                        $zu = $this->createZu($row, $this->gu->id);
                        $well->zu_id = $zu->id;
                        $well->save();


                        $pipe->zu_id = $zu->id;
                        $pipe->well_id = $well->id;
                        $pipe->save();
                    }
                }

                if ($between_points == 'zu-gu') {
                    $this->gu->lat = $row[self::LAT];
                    $this->gu->lon = $row[self::LON];
                    $this->gu->elevation = $row[self::ELEVATION];
                    $this->gu->save();
                    $pipe->color = '[255,0,0]';
                    $pipe->save();
                }

                if ($between_points == 'well-collector') {
                    $pipe_names = explode('&', $pipe->name);

                    foreach ($pipe_names as $pipe_name) {
                        $temp_pipe = MapPipe::where('name', $pipe_name)->first();

                        if ($temp_pipe) {
                            $zu = Zu::find($temp_pipe->zu_id);

                            if ($zu) {
                                $zu->lat = $row[self::LAT];
                                $zu->lon = $row[self::LON];
                                $zu->elevation = $row[self::ELEVATION];
                                $zu->save();

                                $pipe->zu_id = $zu->id;
                                $pipe->save();
                                break;
                            }
                        }
                    }
                }
            }

            $this->createPipeCoord($row, $pipe->id);
        }
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

    private function createWell($row): Well
    {
        $this->command->info('Create Well ' . $row[self::WELL_NAME]);
        $well = Well::firstOrNew(
            [
                'name' => strtoupper($row[self::WELL_NAME]),
                'ngdu_id' => $this->ngdu->id,
                'gu_id' => $this->gu->id
            ]
        );

        $well->lat = $row[self::LAT];
        $well->lon = $row[self::LON];
        $well->elevation = $row[self::ELEVATION];

        return $well;
    }

    private function createZu($row, int $gu_id): Zu
    {
        $this->command->info('Create Zu ' . $row[self::ZU]);
        $zu = Zu::firstOrNew(
            [
                'name' => strtoupper($row[self::ZU]),
                'ngdu_id' => $this->ngdu->id,
                'gu_id' => $this->gu->id
            ]
        );

        if (!$zu->lat || !$zu->lon || !$zu->elevation) {
            $zu->lat = $row[self::LAT];
            $zu->lon = $row[self::LON];
            $zu->elevation = $row[self::ELEVATION];
        }

        $zu->gu_id = $gu_id;

        $zu->save();

        return $zu;
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


    private function getPipeType($row)
    {
        if (!preg_match('/&|ЗУ|ГУ|ФЛ/i', $row[self::PIPE_START_NAME])) {
            return 'well-zu';
        }

        if (preg_match('/ФЛ/i', $row[self::PIPE_START_NAME])) {
            return 'fl-zu';
        }

        if (preg_match('/&/i', $row[self::PIPE_START_NAME]) &&
            !preg_match('/ЗУ|ГУ/i', $row[self::PIPE_START_NAME])) {
            return 'well-collector';
        }


        if (!preg_match('/&|ЗУ/i', $row[self::PIPE_START_NAME]) &&
            preg_match('/ГУ/i', $row[self::PIPE_START_NAME])) {
            return 'gu';
        }

        if (!preg_match('/&/i', $row[self::PIPE_START_NAME]) &&
            preg_match('/ЗУ|ГУ/i', $row[self::PIPE_START_NAME])) {
            return 'zu-gu';
        }
    }

}

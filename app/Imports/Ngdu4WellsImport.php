<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Material;
use App\Models\ComplicationMonitoring\PipeType;
use App\Models\Pipes\OilPipe;
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
use App\Console\Commands\Import\Wells;

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
    const END_PIPE = 15;
    const OUTSIDE_LINE = 16;
    const COLLECTOR = 17;
    const WELL_NUMBER = 18;

    const BETWEEN_POINTS_ARRAY = [
        'well-zu',
        'fl-gu',
        'well-collector',
        'gu',
        'zu-gu',
        'sp-gu'
    ];

    public function __construct(Wells $command)
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
                OilPipe::where('ngdu_id', $this->ngdu->id)->whereIn('between_points', self::BETWEEN_POINTS_ARRAY)->delete();
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
            foreach ($row as $row_index => $value) {
                $row[$row_index] = str_replace(',','.', $row[$row_index]);
            }

            if ($row[self::LAT] == null && $row[self::LON] == null) {
                $message = $row[self::GU].', Pipe '.$row[self::PIPE_NAME].' There no coordinates';
                $this->command->error($message);
                break;
            }

            $row[self::LAT] = str_replace(',','.', $row[self::LAT]);
            $row[self::LON] = str_replace(',','.', $row[self::LON]);
            $row[self::ELEVATION] = str_replace(',','.', $row[self::ELEVATION]);
            $row[self::H_DISTANCE] = str_replace(',','.', $row[self::H_DISTANCE]);
            $row[self::M_DISTANCE] = str_replace(',','.', $row[self::M_DISTANCE]);

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

                $this->gu->ngdu_id = $this->ngdu->id;
                $this->gu->save();

                $this->command->line('----------------------------');
                $this->command->info('Processing ' . $guName);
                $this->command->line('----------------------------');
                $this->command->line(' ');
            }

            if (!empty($row[self::PIPE_START_NAME])) {
                $pipe_type = $this->createPipeType($row);

                $roughness = str_replace(',', '.', $row[self::ROUGHNESS]);
                $roughness = floatval($roughness);
                $material = Material::where('roughness', $roughness)->first();

                $this->command->info('Create Pipe ' . $row[self::PIPE_NAME]);
                $pipe = OilPipe::firstOrCreate(
                    [
                        'name' => $row[self::PIPE_NAME],
                        'ngdu_id' => $this->ngdu->id,
                        'gu_id' => $this->gu->id
                    ]
                );
                PipeCoord::where('oil_pipe_id', $pipe->id)->delete();
                $pipe->type_id = $pipe_type->id;
                $pipe->material_id = $material->id;

                $between_points = $this->getPipeType($row);

                if ($between_points == 'well-zu') {
                    $well = $this->createWell($row);
                }

                if ($between_points == 'zu-gu') {
                    $zu = Zu::where('lat', $row[self::LAT])->where('lon', $row[self::LON])->first();
                    if ($zu) {
                        $pipe->zu_id = $zu->id;
                        $pipe->start_point = $zu->name;
                    }
                }

                if ($between_points == 'sp-gu') {
                    $name = $row[self::PIPE_START_NAME];
                    $name = str_replace('_ГУ','', $name);
                    $name = str_replace('-ГУ','', $name);
                    $pipe->start_point = $name;
                }

                $pipe->gu_id = $this->gu->id;
                $pipe->between_points = $between_points;
                $pipe->save();
            }

            if ($row[self::END_PIPE]) {

                if ($between_points == 'well-zu') {
                    if (!$row[self::ZU]) {
                        $zu = Zu::where('lat', $row[self::LAT])->where('lon', $row[self::LON])->first();

                        if (!$zu) {
                            $message = 'Отсутсвует имя ЗУ, в ' . $this->gu->name . ', скважина ' . $well->name;

                            Log::channel('exel_import')->info($message);
                            $this->command->error($message);

                            $this->errors[] = $message;

                            PipeCoord::where('oil_pipe_id', $pipe->id)->delete();
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
                        $pipe->start_point = $well->name;
                        $pipe->end_point = $zu->name;
                        $pipe->save();
                    }
                }

                if ($between_points == 'zu-gu') {
                    $this->gu->lat = $row[self::LAT];
                    $this->gu->lon = $row[self::LON];
                    $this->gu->elevation = $row[self::ELEVATION];
                    $this->gu->save();
                    $pipe->end_point = $this->gu->name;
                    $pipe->save();
                }

                if ($between_points == 'fl-gu' || $between_points == 'gu-gu') {
                    $pipe->end_point = $this->gu->name;
                    $pipe->start_point = $this->gu->name;
                    $pipe->save();
                }

                if ($between_points == 'well_collector-zu') {
                    $pipe_names = explode('&', $pipe->name);

                    foreach ($pipe_names as $pipe_name) {
                        $temp_pipe = OilPipe::where('name', $pipe_name)->first();

                        if ($temp_pipe) {
                            $zu = Zu::find($temp_pipe->zu_id);

                            if ($zu) {
                                $zu->lat = $row[self::LAT];
                                $zu->lon = $row[self::LON];
                                $zu->elevation = $row[self::ELEVATION];
                                $zu->save();

                                $pipe->zu_id = $zu->id;
                                $pipe->start_point = $pipe->name;
                                $pipe->end_point = $zu->name;
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
        $thickness = ($row[self::OUTSIDE_DIAMETER] - $row[self::INNER_DIAMETER])/2;


        $pipeType =  PipeType::firstOrCreate(
            [
                'outside_diameter' => $row[self::OUTSIDE_DIAMETER],
                'inner_diameter' => $row[self::INNER_DIAMETER],
                'thickness' => $thickness
            ]
        );

        $pipeType->name = (int)$row[self::OUTSIDE_DIAMETER].'x'.(int)$thickness;
        $pipeType->save();

        return $pipeType;
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

    private function createZu($row): Zu
    {
        $this->command->info('Create Zu '.$row[self::ZU]);
        $name = str_replace("СЏ", "СП", strtoupper($row[self::ZU]));
        $name = str_replace("Ѐ", "А", $name);

        $zu = Zu::firstOrNew(
            [
                'ngdu_id' => $this->ngdu->id,
                'gu_id' => $this->gu->id,
                'name' => $name
            ]
        );

        $zu->lat = $row[self::LAT];
        $zu->lon = $row[self::LON];

        $zu->save();

        return $zu;
    }

    private function createPipeCoord($row, int $oilPipeId): void
    {
        $pipe_coords = new PipeCoord;
        $pipe_coords->oil_pipe_id = $oilPipeId;
        $pipe_coords->lat = $row[self::LAT];
        $pipe_coords->lon = $row[self::LON];
        $pipe_coords->elevation = $row[self::ELEVATION];
        $pipe_coords->h_distance = $row[self::H_DISTANCE];
        $pipe_coords->m_distance = $row[self::M_DISTANCE];
        $pipe_coords->save();
    }


    private function getPipeType($row)
    {
        if (!preg_match('/&|ЗУ|ГУ|ФЛ|СП/i', $row[self::PIPE_START_NAME])) {
            return 'well-zu';
        }

        if (preg_match('/СП/i', $row[self::PIPE_START_NAME])) {
            return 'sp-gu';
        }

        if (preg_match('/ФЛ/i', $row[self::PIPE_START_NAME])) {
            return 'fl-gu';
        }

        if (preg_match('/&/i', $row[self::PIPE_START_NAME]) &&
            !preg_match('/ЗУ|ГУ/i', $row[self::PIPE_START_NAME])) {
            return 'well_collector-zu';
        }


        if (!preg_match('/&|ЗУ/i', $row[self::PIPE_START_NAME]) &&
            preg_match('/ГУ/i', $row[self::PIPE_START_NAME])) {
            return 'gu-gu';
        }

        if (!preg_match('/&/i', $row[self::PIPE_START_NAME]) &&
            preg_match('/ЗУ|ГУ/i', $row[self::PIPE_START_NAME])) {
            return 'zu-gu';
        }
    }

}

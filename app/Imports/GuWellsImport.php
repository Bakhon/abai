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
use App\Console\Commands\Import\Wells;

class GuWellsImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow, WithCalculatedFormulas
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
    const GU = 13;
    const OUTSIDE_DIAMETER = 14;
    const PIPE_NAME = 17;
    const START_POINT = 19;
    const FINISH_POINT = 20;
    const COORDS = 21;
    const END_PIPE = 23;
    const COMMENT = 24;

    const BETWEEN_POINTS_ARRAY = [
        'well-zu',
        'fl-gu',
        'well-collector',
        'well_collector-zu',
        'gu-gu',
        'zu-gu',
        'zu-zu_coll',
        'zu_coll-gu',
        'zu_coll-mgu',
        'zu-zu',
        'zu-mgu',
        'mgu-mgu'
    ];

    public function __construct(Wells $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        if (strpos($this->sheetName, 'GU-') === 0) {
            $this->importGu($this->sheetName, $collection);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                if (strpos($this->sheetName, 'НГДУ') === 0) {
                    $this->ngdu = Ngdu::where('name', $this->sheetName)->first();
                    MapPipe::where('ngdu_id', $this->ngdu->id)->whereIn('between_points', self::BETWEEN_POINTS_ARRAY)->delete();
                    Well::where('ngdu_id', $this->ngdu->id)->delete();
                    Zu::whereNull('ngdu_id')->delete();
                }

                if (strpos($this->sheetName, 'GU-') !== 0 AND strpos($this->sheetName, 'НГДУ') !== 0) {
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
        return 'Z';
    }

    private function importGu(string $guName, Collection $collection)
    {
        $guName = str_replace('GU-', 'ГУ-', $guName);
        $this->gu = Gu::firstOrCreate(
            [
                'name' => strtoupper($guName)
            ]
        );

        $this->gu->ngdu_id = $this->ngdu->id;
        $this->gu->save();

        if (!$this->dataIsValid($collection)) {
            return;
        }

        $collection = $collection->skip(1);

        $well = null;
        $between_points = null;
        $pipe = null;
        $zu = null;
        $is_new_pipe = true;
        $is_deleting = false;

        $this->command->line('----------------------------');
        $this->command->info('Processing '.$guName);

        foreach ($collection as $index => $row) {

            if ($row[self::LAT] == null && $row[self::LON] == null) {
                $message = $row[self::GU].', Pipe '.$row[self::PIPE_NAME].' There no coordinates';
                $this->command->error($message);
                break;
            }

            $row[self::LAT] = str_replace(',','.', $row[self::LAT]);
            $row[self::LON] = str_replace(',','.', $row[self::LON]);

            if (!empty($row[self::PIPE_START_NAME]) && $is_new_pipe) {
                if ($row[self::PIPE_NAME] == '#LINK!' || !$row[self::PIPE_NAME]) {
                    $row[self::PIPE_NAME] = $row[self::PIPE_START_NAME];
                }
                $is_new_pipe = false;

                $pipe_type = $this->createPipeType($row);

                $this->command->info('Create Pipe '.$row[self::PIPE_NAME]);
                $pipe = MapPipe::firstOrCreate(
                    [
                        'name' => $row[self::PIPE_NAME],
                        'ngdu_id' => $this->ngdu->id,
                        'gu_id' => $this->gu->id
                    ]
                );
                $pipe->type_id = $pipe_type->id;

                $between_points = $this->getPipeType($row);

                if ($between_points == 'zu-mgu' || $between_points == 'zu_coll-mgu') {
                    $names = explode('-', $row[self::PIPE_START_NAME]);
                    $pipe->end_point = $names[1];
                    $pipe->start_point = $names[0];
                    $pipe->save();
                }

                if ($between_points == 'well-zu') {
                    $this->command->info('Create Well '.$row[self::START_POINT]);
                    $well = $this->createWell($row);
                }

                if ($between_points == 'zu-gu') {
                    $zu = Zu::where('lat', $row[self::LAT])->where('lon', $row[self::LON])->first();

                    if ($zu) {
                        $pipe->zu_id = $zu->id;
                        $pipe->start_point = $zu->name;
                    }

                    $pipe->end_point = $this->gu->name;
                }

                if ($between_points == 'zu-zu_coll') {
                    $zu = Zu::where('lat', $row[self::LAT])->where('lon', $row[self::LON])->first();
                    if ($zu) {
                        $pipe->start_point = $zu->name;
                        $pipe->zu_id = $zu->id;
                    }
                    $pipe->end_point_point = $row[self::PIPE_START_NAME];
                }

                if ($between_points == 'mgu-mgu') {
                    $pipe->start_point = $row[self::FINISH_POINT];
                }



                $pipe->gu_id = $this->gu->id;
                $pipe->between_points = $between_points;
                $pipe->save();
            }

            if ($row[self::COMMENT] &&
                (strpos(mb_strtolower($row[self::COMMENT]), 'ликвид') !== false ||
                    strpos(mb_strtolower($row[self::COMMENT]), 'тательн') !== false ||
                    strpos(mb_strtolower($row[self::COMMENT]), 'нагнет') !== false
                )
            ) {
                if ($pipe) {
                    $pipe->delete();
                }

                $zu = $well = $pipe = $between_points = null;

                if (!$row[self::END_PIPE]) {
                    $is_deleting = true;
                } else {
                    $is_new_pipe = true;
                }

                continue;
            }

            if ($is_deleting && !$row[self::END_PIPE]) {
                continue;
            }

            if ($row[self::END_PIPE]) {
                if ($is_deleting) {
                    $is_deleting = false;
                    $is_new_pipe = true;
                    continue;
                }

                $pipe->comment = $row[self::COMMENT];

                if ($between_points == 'well-zu') {
                    if (!$row[self::FINISH_POINT] || $row[self::FINISH_POINT] == '#N/A') {
                        $zu = Zu::where('lat', $row[self::LAT])->where('lon', $row[self::LON])->first();

                        if (!$zu) {
                            $message = 'Отсутсвует имя ЗУ, в '.$this->gu->name.', скважина '.$well->name;

                            Log::channel('exel_import')->info($message);
                            $this->command->error($message);

                            $this->errors[] = $message;

                            PipeCoord::where('map_pipe_id', $pipe->id)->delete();
                            $pipe->delete();

                            $zu = $well = $pipe = $between_points = null;
                            continue;
                        } else {
                            $row[self::FINISH_POINT] = $zu->name;
                        }
                    }

                    $zu = $this->createZu($row);
                    $well->zu_id = $zu->id;
                    $well->save();

                    $pipe->zu_id = $zu->id;
                    $pipe->well_id = $well->id;
                    $pipe->start_point = $well->name;
                    $pipe->end_point = $zu->name;
                    $pipe->save();
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

                if ($between_points == 'zu-zu_coll') {
                    $pipe->end_point = $row[self::FINISH_POINT];
                    $pipe->save();
                }

                if ($between_points == 'zu_coll-gu') {
                    $pipe->end_point = $this->gu->name;
                    $pipe->save();
                }


                if ($between_points == 'mgu-mgu') {
                    $pipe->end_point = $row[self::FINISH_POINT];
                    $pipe->name = $pipe->start_point.'-'.$pipe->end_point;
                    $pipe->save();
                }

                if ($between_points == 'well_collector-zu') {
                    $pipe_names = explode('&', $pipe->name);
                    $pipe->save();

                    foreach ($pipe_names as $pipe_name) {
                        $temp_pipe = MapPipe::where('name', $pipe_name)->
                            where('ngdu_id', $this->ngdu->id)->
                            where('gu_id', $this->gu->id)->first();

                        if ($temp_pipe) {
                            $zu = Zu::find($temp_pipe->zu_id);

                            if ($zu) {
                                $zu->lat = $row[self::LAT];
                                $zu->lon = $row[self::LON];
                                $zu->elevation = $row[self::ELEVATION];
                                $zu->save();

                                $pipe->start_point = $pipe->name;
                                $pipe->end_point = $zu->name;
                                $pipe->zu_id = $zu->id;
                                $pipe->save();
                                break;
                            }
                        }
                    }
                }

                $is_new_pipe = true;
            }

            $this->createPipeCoord($row, $pipe->id);
        }

        $this->command->info($guName.' Finished');
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

    private function createWell($row): Well
    {
        $well = Well::firstOrNew(
            [
                'name' => strtoupper($row[self::START_POINT]),
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
        $this->command->info('Create Zu '.$row[self::FINISH_POINT]);
        $zu = Zu::firstOrNew(
            [
                'name' => strtoupper($row[self::FINISH_POINT]),
                'ngdu_id' => $this->ngdu->id,
                'gu_id' => $this->gu->id
            ]
        );

        $zu->lat = $row[self::LAT];
        $zu->lon = $row[self::LON];
        $zu->elevation = $row[self::ELEVATION];

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


    private function getPipeType ($row)
    {
        if (!preg_match('/&|gu|zu|fl/i', $row[self::PIPE_START_NAME])) {
            return 'well-zu';
        }

        if (preg_match('/mgu/i', $row[self::PIPE_START_NAME]) AND
            preg_match('/mgu/i', $row[self::FINISH_POINT])) {
            return 'mgu-mgu';
        }

        if (preg_match('/zu.+&.+mgu/i', $row[self::PIPE_START_NAME])) {
            return 'zu_coll-mgu';
        }

        if (preg_match('/zu.+mgu/i', $row[self::PIPE_START_NAME])) {
            return 'zu-mgu';
        }

        if (preg_match('/zu.+zu/i', $row[self::PIPE_START_NAME]) AND
            !preg_match('/gu/i', $row[self::PIPE_START_NAME])) {
            return 'zu-zu_coll';
        }

        if (preg_match('/zu.+zu.+gu/i', $row[self::PIPE_START_NAME])) {
            return 'zu_coll-gu';
        }

        if (preg_match('/zu.+gu/i', $row[self::PIPE_START_NAME])) {
            return 'zu-gu';
        }

        if (preg_match('/383_ЗУ/i', $row[self::PIPE_START_NAME])) {
            return 'well-zu';
        }

        if (preg_match('/fl/i', $row[self::PIPE_START_NAME]) || preg_match('/фл/i', $row[self::PIPE_START_NAME])) {
            return 'fl-gu';
        }

        if (preg_match('/&/i', $row[self::PIPE_START_NAME]) &&
            !preg_match('/gu|zu/i', $row[self::PIPE_START_NAME])) {
            return 'well_collector-zu';
        }


        if (!preg_match('/&|zu/i', $row[self::PIPE_START_NAME]) &&
            preg_match('/gu/i', $row[self::PIPE_START_NAME])) {
            return 'gu-gu';
        }

        if (!preg_match('/&/i', $row[self::PIPE_START_NAME]) &&
            preg_match('/gu|zu/i', $row[self::PIPE_START_NAME])) {
            return 'zu-gu';
        }
    }

}

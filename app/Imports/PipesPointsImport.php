<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportPipesPoints;
use App\Models\ComplicationMonitoring\TrunklinePoint;
use App\Models\Pipes\PipeCoord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;
use App\Models\ComplicationMonitoring\Gu;

class PipesPointsImport implements ToCollection, WithEvents, WithColumnLimit, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const NGDU = 0;
    const START_POINT = 1;
    const END_POINT = 2;
    const COORDS = 3;
    const LAT = 1;
    const LON = 0;

    public function __construct(ImportPipesPoints $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        if (strpos($this->sheetName, 'Trunkline_Points') !== false) {
            $this->importPoints($collection);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                if (strpos($this->sheetName, 'Trunkline_Points') === false) {
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
        return 'E';
    }

    private function importPoints(Collection $collection)
    {
        $collection = $collection->skip(1);

        foreach ($collection as $row) {

            $coords = json_decode($row[self::COORDS]);
            $start_coords = $coords[0];
            $end_coords = end($coords);


            $oil_pipe_id = DB::select(
                DB::raw(
                    "SELECT pipe_coords.oil_pipe_id FROM `pipe_coords`
                LEFT JOIN (SELECT * FROM `pipe_coords` 
                    WHERE `lon` LIKE :end_coords_lon AND `lat` LIKE :end_coords_lat) end_coords 
                    ON end_coords.`oil_pipe_id` = pipe_coords.oil_pipe_id
                WHERE pipe_coords.`lat` LIKE :start_coords_lat
                            AND pipe_coords.`lon` LIKE :start_coords_lon
                            AND pipe_coords.id IS NOT NULL
                            AND end_coords.id IS NOT NULL"
                ),
                array(
                    'end_coords_lon' => $end_coords[self::LON],
                    'end_coords_lat' => $end_coords[self::LAT],
                    'start_coords_lat' => $start_coords[self::LAT],
                    'start_coords_lon' => $start_coords[self::LON]
                )
            )[0]->oil_pipe_id;

            $pipe_coords_start = PipeCoord::where('lat', $start_coords[self::LAT])
                ->where('lon', $start_coords[self::LON])
                ->where('oil_pipe_id', $oil_pipe_id)
                ->where('m_distance', 0)
                ->first();

            $pipe_coords_end = PipeCoord::where('oil_pipe_id', $oil_pipe_id)
                ->orderByDesc('m_distance')
                ->first();

            $trunkline_end_point = TrunklinePoint::firstOrCreate(
                [
                    'ngdu_id' => $row[self::NGDU],
                    'name' => $row[self::END_POINT],
                    'lat' => $pipe_coords_end->lat,
                    'lon' => $pipe_coords_end->lon,
                    'elevation' => $pipe_coords_end->elevation
                ]
            );

            $trunkline_end_point->oil_pipe_id = $oil_pipe_id;
            $trunkline_end_point->save();

            $trunkline_start_point = TrunklinePoint::firstOrCreate(
                [
                    'ngdu_id' => $row[self::NGDU],
                    'name' => $row[self::START_POINT],
                    'lat' => $pipe_coords_start->lat,
                    'lon' => $pipe_coords_start->lon,
                    'elevation' => $pipe_coords_start->elevation,
                    'point_end_id' => $trunkline_end_point->id
                ]
            );

            $trunkline_start_point->oil_pipe_id = $oil_pipe_id;

            if (strpos($trunkline_start_point->name, 'ГУ') !== false) {
                $gu = Gu::where('name', $trunkline_start_point->name)->first();
                $trunkline_start_point->gu_id = $gu->id;
            }

            $trunkline_start_point->save();
        }

        throw new \Exception('Success import');
    }
}

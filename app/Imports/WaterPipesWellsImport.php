<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportWaterWells;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\WaterPipePoint;
use App\Models\ComplicationMonitoring\WaterWell;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class WaterPipesWellsImport implements ToCollection, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const COLUMNS = [
        'lon' => 0,
        'lat' => 1,
        'object_id' => 2,
        'length' => 3,
        'point_x' => 4,
        'point_y' => 5
    ];

    public function __construct(ImportWaterWells $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        $this->importWaterPipes($collection);
        $this->searchWaterWells();
        $this->command->info('Import Finished');
    }

    public function endColumn(): string
    {
        return 'G';
    }

    private function importWaterPipes(Collection $collection)
    {
        $collection = $collection->skip(1);
        $length = null;
        $pipe = null;
        $pipe_length = null;
        $pipes = 0;

        foreach ($collection as $row) {
            if (!$row[self::COLUMNS['lon']] OR $pipes > 150) {
                break;
            }

            foreach (self::COLUMNS as $COLUMN) {
                $row[$COLUMN] = str_replace(',', '.', $row[$COLUMN]);
            }

            if ($length != $row[self::COLUMNS['length']]) {
                $pipe = $this->createNewPipe($row);
                $pipe_length = 0;
                $pipes++;
            }

            $length = $row[self::COLUMNS['length']];
            $pipe_coord = new PipeCoord();
            $pipe_coord->lat = $row[self::COLUMNS['lat']];
            $pipe_coord->lon = $row[self::COLUMNS['lon']];
            $pipe_coord->elevation = 0;
            $pipe_coord->oil_pipe_id = $pipe->id;
            $pipe_coord->h_distance = $pipe_length;
            $pipe_coord->m_distance = $pipe_length;
            $pipe_coord->save();

            $water_pipe_point = new WaterPipePoint();
            $water_pipe_point->oil_pipe_id = $pipe->id;
            $water_pipe_point->pipe_coord_id = $pipe_coord->id;
            $water_pipe_point->object_id = $row[self::COLUMNS['object_id']];
            $water_pipe_point->point_x = $row[self::COLUMNS['point_x']];
            $water_pipe_point->point_y = $row[self::COLUMNS['point_y']];
            $water_pipe_point->save();

            $pipe_length = $length;
        }

        $this->command->info('Parse pipes finished');
    }

    public function createNewPipe ($row): OilPipe
    {
        $this->command->info('create water pipe, object_id '.$row[self::COLUMNS['object_id']]);

        $pipe = new OilPipe();
        $pipe->between_points = 'water-pipe';
        $pipe->water_pipe = true;
        $pipe->save();

        return $pipe;
    }

    public function searchWaterWells()
    {
        $this->command->info('Search wells started');
        $pipes = OilPipe::where('water_pipe', true)->get();
        $pipes_ids = $pipes->pluck('id');
        foreach ($pipes as $pipe) {
            $last_pipe_coords = PipeCoord::where('oil_pipe_id', $pipe->id)->orderByDesc('id')->first();
            $same_coords = PipeCoord::where('oil_pipe_id', '!=', $pipe->id)
                ->where('lat', $last_pipe_coords->lat)
                ->where('lon', $last_pipe_coords->lon)
                ->where('h_distance', 0)
                ->whereIn('oil_pipe_id', $pipes_ids)
                ->first();

            if (!$same_coords) {
                $this->createWaterWell($last_pipe_coords);
            }
        }

        $this->command->info('Search wells finished');
    }

    public function createWaterWell($pipe_coord)
    {
        $this->command->info('create water well with coords ' . $pipe_coord->lat.', '.$pipe_coord->lon);

        $ww = new WaterWell();
        $ww->lon = $pipe_coord->lon;
        $ww->lat = $pipe_coord->lat;
        $ww->save();
    }

    public function startRow(): int
    {
        return 1;
    }
}

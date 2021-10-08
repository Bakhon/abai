<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportNewPipes;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\PipeType;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;

class NewPipesImport implements ToCollection, WithColumnLimit
{
    public $command;
    public $is_start_pipe = true;

    const COLUMNS = [
        'well' => 0,
        'distance' => 1,
        'm_distance' => 2,
        'lat' => 3,
        'lon' => 4,
        'elevation' => 5,
        'zu' => 6,
        'end_pipe' => 7
    ];

    public function __construct(ImportNewPipes $command)
    {
        $this->command = $command;
    }

    public function collection(Collection $collection)
    {
        $this->importNewPipes($collection);
    }

    public function endColumn(): string
    {
        return 'I';
    }

    private function importNewPipes(Collection $collection)
    {
        $collection = $collection->skip(1);
        $pipe_type = PipeType::where('name', '114x8')->first();

        foreach ($collection as $row) {
            foreach (self::COLUMNS as $column) {
                $row[$column] = str_replace(',','.', $row[$column]);
            }

            if ($this->is_start_pipe) {
                $zu = Zu::where('name', $row[self::COLUMNS['zu']])->first();
                $well = Well::where('zu_id', $zu->id)
                    ->where('name', 'LIKE', '%'.$row[self::COLUMNS['well']].'%')
                    ->first();

                if (!$well) {
                    dd($row);
                }

                $pipe = OilPipe::firstOrCreate(
                    [
                        'name' => $row[self::COLUMNS['well']],
                        'between_points' => 'well-zu',
                        'zu_id' => $zu->id,
                        'well_id' => $well->id
                    ]
                );

                $pipe->start_point = $well->name;
                $pipe->end_point = $zu->name;
                $pipe->gu_id = $well->gu_id;
                $pipe->ngdu_id = $well->ngdu_id;
                $pipe->type_id = $pipe_type->id;
                $pipe->save;

                $well->lat = round($row[self::COLUMNS['lat']], 12);
                $well->lon = round($row[self::COLUMNS['lon']], 12);
                $well->elevation = $row[self::COLUMNS['elevation']];
                $well->gu_id = $zu->gu_id;
                $well->save();

                PipeCoord::where('oil_pipe_id', $pipe->id)->forceDelete();
            }

            $coord = new PipeCoord();
            $coord->lat = round($row[self::COLUMNS['lat']], 12);
            $coord->lon = round($row[self::COLUMNS['lon']], 12);
            $coord->elevation = $row[self::COLUMNS['elevation']];
            $coord->h_distance = $row[self::COLUMNS['distance']];
            $coord->m_distance = $row[self::COLUMNS['m_distance']];
            $coord->oil_pipe_id = $pipe->id;
            $coord->save();

            $this->is_start_pipe = filter_var($row[self::COLUMNS['end_pipe']], FILTER_VALIDATE_BOOLEAN);
        }

        throw new \Exception('Success import');
    }
}

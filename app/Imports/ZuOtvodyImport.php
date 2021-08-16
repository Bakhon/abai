<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;

class ZuOtvodyImport implements ToCollection, WithColumnLimit, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const COLUMNS = [
        'zu' => 2,
        'otvod' => 1,
        'well' => 3,
    ];

    public function __construct(\App\Console\Commands\Import\ZuOtvody $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        $this->importMeasurements($collection);
    }

    public function endColumn(): string
    {
        return 'H';
    }

    private function importMeasurements(Collection $collection)
    {
        $collection = $collection->skip(1);

        foreach ($collection as $row) {
            $zu = Zu::where('name', $row[self::COLUMNS['zu']])->first();

            if ($zu) {
                $well = Well::where('zu_id', $zu->id)
                    ->where('name', 'like', '%'.strtoupper($row[self::COLUMNS['well']]).'%')
                    ->first();

                if ($well) {
                    $well->otvod = $row[self::COLUMNS['otvod']];
                    $well->save();
                } else {
                    $message = 'Не найдена скважина ' . $row[self::COLUMNS['well']] . ', ЗУ ' . $row[self::COLUMNS['zu']];
                    $this->command->error($message);
                }
            } else {
                $message = 'Не найдена ЗУ '. $row[self::COLUMNS['zu']];
                $this->command->error($message);
            }


        }
    }
}

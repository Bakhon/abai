<?php

namespace App\Imports;

use App\Console\Commands\Import\importKmbWells;
use App\Models\ComplicationMonitoring\KmbWell;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class WaterKmbWellsImport implements ToCollection, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const COLUMNS = [
        'lon' => 0,
        'lat' => 1,
        'name' => 2,
        'type' => 3,
        'status' => 4,
        'well_number' => 5,
        'well_type' => 6,
        'drilling_date' => 7
    ];

    public function __construct(importKmbWells $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        $this->importKmbWaterWells($collection);
        $this->command->info('Import Finished');
    }

    public function endColumn(): string
    {
        return 'I';
    }

    private function importKmbWaterWells(Collection $collection)
    {
        $collection = $collection->skip(1);

        foreach ($collection as $row) {
            foreach (self::COLUMNS as $COLUMN) {
                $row[$COLUMN] = str_replace(',', '.', $row[$COLUMN]);
            }

            $kmb_well = new KmbWell();

            foreach (self::COLUMNS as $key => $column) {
                $kmb_well->$key = $row[$column];
            }
            $kmb_well->save();

            $this->command->info($kmb_well->name.' Imported');
        }
    }

    public function startRow(): int
    {
        return 1;
    }
}

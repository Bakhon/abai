<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportWaterWells;
use App\Models\ComplicationMonitoring\WaterWell;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class WaterWellsImport implements ToCollection, WithColumnLimit, WithStartRow, WithCalculatedFormulas
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

    public function __construct(ImportWaterWells $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        $this->importWaterWells($collection);
        $this->command->info('Import Finished');
    }

    public function endColumn(): string
    {
        return 'I';
    }

    private function importWaterWells(Collection $collection)
    {
        $collection = $collection->skip(1);


        foreach ($collection as $row) {
            foreach (self::COLUMNS as $COLUMN) {
                $row[$COLUMN] = str_replace(',', '.', $row[$COLUMN]);
            }

            $water_well = new WaterWell();

            foreach (self::COLUMNS as $key => $column) {
                $water_well->$key = $row[$column];
            }
            $water_well->save();

            $this->command->info($water_well->name.' Imported');
        }
    }

    public function startRow(): int
    {
        return 1;
    }
}

<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportBknsWells;
use App\Models\ComplicationMonitoring\BknsWell;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class WaterBknsWellsImport implements ToCollection, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const COLUMNS = [
        'lon' => 0,
        'lat' => 1,
        'name' => 2,
        'x_point' => 3,
        'y_point' => 4
    ];

    public function __construct(ImportBknsWells $command)
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

            $bkns_well = new BknsWell();

            foreach (self::COLUMNS as $key => $column) {
                $bkns_well->$key = $row[$column];
            }
            $bkns_well->save();

            $this->command->info($bkns_well->name.' Imported');
        }
    }

    public function startRow(): int
    {
        return 1;
    }
}

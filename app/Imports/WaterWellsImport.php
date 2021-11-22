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
        $this->importWaterWells($collection);
    }

    public function endColumn(): string
    {
        return 'G';
    }

    private function importWaterWells(Collection $collection)
    {
        $collection = $collection->skip(1);

        foreach ($collection as $row) {
            foreach (self::COLUMNS as $COLUMN) {
                $row[$COLUMN] = str_replace(',', '.', $row[$COLUMN]);
            }

            $this->createNewWaterWell($row);
        }

        $this->command->info('Import Finished');
    }

    public function createNewWaterWell($row)
    {
        $this->command->info('import water well ' . $row[self::COLUMNS['object_id']]);

        $ww = new WaterWell();
        foreach (self::COLUMNS as $param => $column){
            $ww->$param = $row[$column];
        }
        $ww->save();
    }

    public function startRow(): int
    {
        return 1;
    }
}

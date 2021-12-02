<?php

namespace App\Imports;

use App\Console\Commands\Import\ImportBGs;
use App\Models\ComplicationMonitoring\BG;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BGsImport implements ToCollection, WithColumnLimit, WithStartRow, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const COLUMNS = [
        'lon' => 0,
        'lat' => 1,
        'comment' => 2,
        'name' => 3,
        'status' => 4
    ];

    public function __construct(ImportBGs $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        $this->importBgs($collection);
    }

    public function endColumn(): string
    {
        return 'F';
    }

    private function importBgs(Collection $collection)
    {
        $collection = $collection->skip(1);

        foreach ($collection as $row) {
            foreach (self::COLUMNS as $COLUMN) {
                $row[$COLUMN] = str_replace(',', '.', $row[$COLUMN]);
            }

            $bg = new BG();

            foreach (self::COLUMNS as $key => $column) {
                $bg->$key = $row[$column];
            }

            $bg_same_name = BG::select(DB::raw("*, SUBSTRING(name, LOCATE('_', name) +1 ) as number"))
                ->where('name', 'like', '%'.$row[self::COLUMNS['name']].'%')
                ->orderByRaw('ABS(number) DESC')
                ->first();

            if ($bg_same_name) {
                $pos = strpos($bg_same_name->name, "_");
                $number = $pos ? substr($bg_same_name->name, $pos + 1) + 1 : null;
                $bg->name = $number ? $row[self::COLUMNS['name']].'_'.$number   : $row[self::COLUMNS['name']].'_1';
            }

            $bg->save();

            $this->command->info($bg->name.' Imported');
        }
    }

    public function startRow(): int
    {
        return 1;
    }
}

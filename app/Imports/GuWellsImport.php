<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class GuWellsImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow
{
    public $sheetName;
    protected $gu;
    protected $wells;
    protected $zus;

    public function __construct()
    {
        $this->sheetName = null;
        $this->wells = [];
        $this->zus = [];
    }

    public function collection(Collection $collection)
    {
        if (strpos($this->sheetName, 'GU-') === 0) {
            dump($this->sheetName);
            $this->importGu($this->sheetName, $collection);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();
            }
        ];
    }

    public function endColumn(): string
    {
        return 'T';
    }

    private function importGu(string $guName, Collection $collection)
    {
        $guName = str_replace('GU-', 'ГУ-', $guName);
        $this->gu = \App\Models\Refs\Gu::where('name', $guName)->first();

        if (!$this->dataIsValid($collection)) {
            return;
        }

        $collection = $collection->skip(1);

        $well = null;

        foreach ($collection as $row) {
            $wellName = $row[19];
            $well = \App\Models\Refs\Well::where('name', $wellName)->first();

            if (!empty($well)) {
                $well->lat = $row[3];
                $well->lon = $row[4];
                $well->save();
            }
        }
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
}

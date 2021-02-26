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
        return 'W';
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
        $prevWellName = '';
        $wells = [];

        foreach ($collection as $row) {

            if(!in_array($row[19], $wells)) {
                $well = \App\Models\Refs\Well::where('name', $row[19])->first();
                $well->lat = $row[3];
                $well->lon = $row[4];
                $well->save();

                $wells[] = $row[19];
            }

            if(!empty($prevWellName) && $prevWellName !== $row[19] && !empty($coords)) {
                $well = \App\Models\Refs\Well::where('name', $prevWellName)->first();

                $coords = array_map(function($item){
                    return [$item[1], $item[0]];
                }, $coords);

                if (!empty($well)) {

                    $zuWellPipe = \App\Models\Pipes\ZuWellPipe::where('well_id', $well->id)->first();
                    if(empty($zuWellPipe)) {
                        if(empty($well->zu)) continue;
                        \App\Models\Pipes\ZuWellPipe::create(
                            [
                                'gu_id' => $well->zu->gu_id,
                                'zu_id' => $well->zu_id,
                                'well_id' => $well->id,
                                'coordinates' => $coords
                            ]
                        );
                    }
                    else {
                        $zuWellPipe->coordinates = $coords;
                        $zuWellPipe->save();
                    }
                }
            }

            $coords = json_decode($row[21]);
            $prevWellName = $row[19];
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

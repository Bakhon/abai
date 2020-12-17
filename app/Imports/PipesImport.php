<?php

namespace App\Imports;

use App\Models\GuPipe;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class PipesImport implements ToCollection, WithEvents, WithColumnLimit, WithStartRow
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
//        try {
            if (strpos($this->sheetName, 'GU-') === 0) {
                dump($this->sheetName);
                $this->importGu($this->sheetName, $collection);
            }
//        } catch (\Exception $e) {
//            dump($e->getMessage());
//        }
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
        return 'F';
    }

    private function importGu(string $guName, Collection $collection)
    {
        $guName = str_replace('GU-', 'ГУ-', $guName);
        $this->gu = \App\Models\Refs\Gu::where('name', $guName)->first();

        if ($this->validateData($collection)) {
            $collection = $collection->skip(1);

            $well = null;

            $coordinates = [];

            foreach ($collection as $row) {
                if (!empty($row[0])) {
                    if (!empty($coordinates)) {

                        $this->importEntity($coordinates, $entityName);
                        $coordinates = [];

                    }

                    $entityName = $row[0];
                }

                $coordinates[] = [
                    $row[3],
                    $row[4],
                ];

            }
        }
    }

    private function validateData(Collection $collection)
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

    private function importEntity(array $coordinates, string $entityName)
    {
        list($entityType, $entity) = $this->guessEntity($entityName);

        switch($entityType) {
            case 'well':

                if(!empty($entity)) {
                    $zuWellPipe = \App\Models\Pipes\ZuWellPipe::where('well_id', $entity->id)->first();
                    if(empty($zuWellPipe)) {
                        \App\Models\Pipes\ZuWellPipe::create(
                            [
                                'gu_id' => $this->gu->id,
                                'zu_id' => $entity ? $entity->zu->id : null,
                                'well_id' => $entity ? $entity->id : null,
                                'coordinates' => $coordinates
                            ]
                        );
                    }
                }

                break;

            case 'zu':

                //I don't know why, it just works
                if(!$entity instanceof \App\Models\Refs\Zu) {
                    $entity = $entity->first();
                }

                if(!empty($entity)) {
                    $guZuPipe = \App\Models\Pipes\GuZuPipe::where('zu_id', $entity->id)->first();
                    if(empty($guZuPipe)) {
                        \App\Models\Pipes\GuZuPipe::create(
                            [
                                'gu_id' => $this->gu->id,
                                'zu_id' => $entity ? $entity->id : null,
                                'coordinates' => $coordinates
                            ]
                        );
                    }
                }

                break;
        }

        $coordinates = [];
    }

    private function guessEntity(string $entityName)
    {
        $wells = $this->getWells($this->gu);
        if (array_key_exists($entityName, $wells)) {
            $well = null;
            $wellId = $wells[$entityName]['id'];
            if($wellId) {
                $well = \App\Models\Refs\Well::find($wellId);
            }
            return ['well', $well];
        }
        else {

            $zus = $this->getZus($this->gu);
            foreach(array_keys($zus) as $zuName) {
                if(strpos(strtolower($entityName), $zuName) !== false) {
                    $zu = \App\Models\Refs\Zu::find($zus[$zuName]);
                    return ['zu', $zu];
                }
            }

        }

        dump($entityName);

        return [null, null];
    }

    private function getWells($gu)
    {
        if(isset($this->wells[$gu->id])) {
            return $this->wells[$gu->id];
        }

        $zus = $gu->zus;
        foreach($zus as $zu) {
            foreach ($zu->wells as $well) {
                $name = (int)substr($well->name, 4);
                $result[$name] = [
                    'id' => $well->id,
                ];
            }
        }
        $this->wells[$gu->id] = $result;
        return $result;
    }

    private function getZus($gu)
    {
        if(isset($this->zus[$gu->id])) {
            return $this->zus[$gu->id];
        }

        foreach ($gu->zus as $zu) {
            $name = Str::slug($zu->name);
            $result[$name] = [
                'id' => $zu->id,
            ];
        }
        $this->zus[$gu->id] = $result;
        return $result;
    }
}

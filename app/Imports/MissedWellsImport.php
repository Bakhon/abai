<?php

namespace App\Imports;

use App\Console\Commands\OilParse;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\ComplicationMonitoring\Cdng;
use App\Models\Refs\HydrocarbonOxidizingBacteria;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\Refs\OtherObjects;
use App\Models\Refs\SulphateReducingBacteria;
use App\Models\Refs\ThionicBacteria;
use App\Models\Refs\WaterTypeBySulin;
use App\Models\ComplicationMonitoring\Zu;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeSheet;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Gu;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MissedWellsImport implements ToCollection, WithColumnLimit, WithCalculatedFormulas
{
    public $sheetName;
    public $command;

    const COLUMNS = [
        'well' => 0,
        'lon' => 1,
        'lat' => 2,
        'zu' => 3,
    ];

    public function __construct(\App\Console\Commands\Import\MissedWells $command)
    {
        $this->command = $command;
        $this->sheetName = null;
    }

    public function collection(Collection $collection)
    {
        $this->import($collection);
    }

    public function endColumn(): string
    {
        return 'D';
    }

    private function import (Collection $collection)
    {
        $collection = $collection->skip(1);

        foreach ($collection as $row) {
            $endpoint = 'https://api.mapbox.com/v4/mapbox.mapbox-terrain-v2/tilequery/'.$row[self::COLUMNS['lon']].','.$row[self::COLUMNS['lat']].'.json?radius=25&limit=50&access_token='.env('MIX_MAPBOX_TOKEN');
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $endpoint);
            $content = json_decode($response->getBody()->getContents());

            $elevation = 0;



            foreach ($content->features as $feature) {
                if (property_exists($feature->properties, 'ele')) {
                    $elevation = $feature->properties->ele > $elevation ? $feature->properties->ele : $elevation;
                }

            }

            $zu = Zu::where('name', trim($row[self::COLUMNS['zu']]))->first();

            if ($zu) {
                $well = Well::firstOrNew([
                        'name' => $row[self::COLUMNS['well']],
                        'zu_id' => $zu->id
                    ]);

                $well->lat = $row[self::COLUMNS['lat']];
                $well->lon = $row[self::COLUMNS['lon']];
                $well->gu_id = $zu->gu_id;
                $well->elevation = $elevation;
                $well->ngdu_id = $zu->ngdu_id;
                $well->save();

                $this->command->info($well->name.' added ЗУ '. $zu->name);
            } else {
                $message = 'Не найдена ЗУ '. $row[self::COLUMNS['zu']];
                $this->command->error($message);
            }
        }
        $this->command->info('Import finished');
    }
}
